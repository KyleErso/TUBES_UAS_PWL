const Event = require('../models/Event');
const Registration = require('../models/Registration');

// Create a new event
const createEvent = async (req, res) => {
  try {
    const {
      judul,
      deskripsi,
      tanggal,
      waktu, // ⬅️ tambahkan ini
      lokasi,
      kapasitas,
      durasi,
      biaya,
      sesi,
      poster // ⬅️ ini ditambahkan dari body, bukan file
    } = req.body;

    // Parsing sesi jika dikirim dalam bentuk string
    let sesiArray = [];
    if (sesi) {
      try {
        sesiArray = typeof sesi === 'string' ? JSON.parse(sesi) : sesi;
      } catch (parseError) {
        return res.status(400).json({ message: 'Format sesi tidak valid' });
      }
    }

    const newEvent = await Event.create({
      judul,
      deskripsi,
      tanggal,
      waktu, // ⬅️ tambahkan ini
      lokasi,
      kapasitas,
      poster: poster ?? null, // ⬅️ simpan link langsung
      sesi: sesiArray,
      durasi,
      biaya,
      pendaftar: [],
      status: 'upcoming',
      panitia: [req.user._id]
    });

    res.status(201).json({
      message: 'Event berhasil dibuat',
      event: newEvent
    });
  } catch (error) {
    res.status(500).json({ message: 'Gagal membuat event', error: error.message });
  }
};


// Get all events
const getEvents = async (req, res) => {
  try {
    // Ambil semua event
    const events = await Event.find().lean();

    // Untuk setiap event, ambil daftar registrasi dan user peserta
    for (let event of events) {
      // Cari semua registrasi untuk event ini
      const registrations = await Registration.find({ event: event._id, status: { $in: ['approved', 'paid', 'checked_in', 'waiting_approval'] } })
        .populate('user', 'nama email _id')
        .lean();

      // Masukkan daftar user ke event.pendaftar
      event.pendaftar = registrations.map(reg => ({
        ...reg.user,
        hadir: reg.hadir,
        sertifikat: reg.sertifikat // jika ingin tampilkan juga
      }));
    }

    res.json({
      message: 'Daftar event berhasil diambil',
      events
    });
  } catch (error) {
    res.status(500).json({ message: 'Gagal mengambil daftar event', error: error.message });
  }
};

// Get a single event by ID
const getEventById = async (req, res) => {
  try {
    const { id } = req.params;
    const event = await Event.findById(id);
    
    if (!event) {
      return res.status(404).json({ message: 'Event tidak ditemukan' });
    }
    
    res.json({
      message: 'Event berhasil ditemukan',
      event
    });
  } catch (error) {
    res.status(500).json({ message: 'Gagal mendapatkan event', error: error.message });
  }
};

// Update event by ID
const updateEvent = async (req, res) => {
  try {
    const { id } = req.params;
    // If a new poster is uploaded replace it
    const updateData = req.body;
    if (req.file) {
      updateData.poster = req.file.path;
    }
    
    const updatedEvent = await Event.findByIdAndUpdate(id, updateData, { new: true });
    
    if (!updatedEvent) {
      return res.status(404).json({ message: 'Event tidak ditemukan' });
    }
    
    res.json({
      message: 'Event berhasil diperbarui',
      event: updatedEvent
    });
  } catch (error) {
    res.status(500).json({ message: 'Gagal mengupdate event', error: error.message });
  }
};

// Ubah fungsi deleteEvent menjadi nonaktifkan event
const deactivateEvent = async (req, res) => {
  try {
    const { id } = req.params;
    const event = await Event.findByIdAndUpdate(
      id,
      { status: 'inactive' },
      { new: true }
    );

    if (!event) {
      return res.status(404).json({ message: 'Event tidak ditemukan' });
    }

    res.json({ message: 'Event berhasil dinonaktifkan', event });
  } catch (error) {
    res.status(500).json({ message: 'Gagal menonaktifkan event', error: error.message });
  }
};

const scanAttendance = async (req, res) => {
  try {
    const { kodeAbsensi } = req.body;

    // Cari data registrasi berdasarkan kode absensi
    const registration = await Registration.findOne({ kodeAbsensi }).populate('user').populate('event');

    if (!registration) {
      return res.status(404).json({ message: 'Kode absensi tidak ditemukan' });
    }

    if (registration.hadir) {
      return res.status(400).json({ message: 'Peserta sudah check-in sebelumnya' });
    }

    // Tandai hadir dan simpan waktu check-in
    registration.hadir = true;
    registration.checkInAt = new Date();
    await registration.save();

    res.status(200).json({
      message: 'Check-in berhasil',
      peserta: {
        nama: registration.user.nama,
        email: registration.user.email
      },
      event: {
        judul: registration.event.judul,
        tanggal: registration.event.tanggal
      },
      waktu: registration.checkInAt
    });
  } catch (error) {
    res.status(500).json({ message: 'Gagal melakukan check-in', error: error.message });
  }
};

// Upload certificate for a participant
const uploadCertificate = async (req, res) => {
  try {
    const { eventId, participantId, sertifikat } = req.body;

    if (!sertifikat || typeof sertifikat !== 'string') {
      return res.status(400).json({ message: 'Link sertifikat tidak valid' });
    }

    const registration = await Registration.findOne({ event: eventId, user: participantId });
    if (!registration) {
      return res.status(404).json({ message: 'Registrasi peserta tidak ditemukan' });
    }
    if (!registration.hadir) {
      return res.status(400).json({ message: 'Sertifikat hanya bisa diupload jika peserta sudah absen (hadir).' });
    }

    registration.sertifikat = sertifikat;
    await registration.save();

    res.json({
      message: 'Sertifikat berhasil diupload',
      sertifikat: registration.sertifikat
    });
  } catch (error) {
    res.status(500).json({ message: 'Gagal mengupload sertifikat', error: error.message });
  }
};

// Get all registrations for a specific event
const getRegistrationsByEvent = async (req, res) => {
  try {
    const { eventId } = req.query;
    if (!eventId) {
      return res.status(400).json({ message: 'eventId wajib diisi' });
    }

    // Ambil semua registration untuk event ini, beserta data user
    const registrations = await Registration.find({ event: eventId })
      .populate('user', 'nama email _id')
      .lean();

    res.json({
      message: 'Daftar registrasi berhasil diambil',
      registrations
    });
  } catch (error) {
    res.status(500).json({ message: 'Gagal mengambil daftar registrasi', error: error.message });
  }
};

module.exports = {
  createEvent,
  getEvents,
  getEventById,
  updateEvent,
  deactivateEvent, // Tambahkan baris ini
  scanAttendance,
  uploadCertificate,
  getRegistrationsByEvent
};