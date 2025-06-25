const Event = require('../models/Event');

// Helper untuk update status event otomatis
function updateEventStatus(event) {
    const today = new Date();
    const eventDate = new Date(event.tanggal);

    if (event.status !== 'inactive') {
        if (eventDate.toDateString() === today.toDateString()) {
            event.status = 'berlangsung'; // ubah jadi "berlangsung" jika hari ini
        } else if (eventDate < today) {
            event.status = 'berlangsung'; // lewat hari, jadi "selesai"
        } else if (eventDate > today) {
            event.status = 'upcoming'; // belum hari H, tetap upcoming
        }
    }
    return event;
}

// Mendapatkan semua event lengkap (tanpa .select, jadi semua field ikut dikembalikan)
exports.getAllEvents = async (req, res) => {
    try {
        let events = await Event.find().sort({ tanggal: 1 });

        // Update status otomatis sebelum dikirim ke client
        events = await Promise.all(events.map(async (event) => {
            const updatedEvent = updateEventStatus(event);
            // Simpan jika status berubah
            if (event.status !== updatedEvent.status) {
                event.status = updatedEvent.status;
                await event.save();
            }
            return event;
        }));

        res.status(200).json({
            message: 'Berhasil mendapatkan daftar event',
            events
        });
    } catch (error) {
        res.status(500).json({
            message: 'Terjadi kesalahan server',
            error: error.message
        });
    }
};

// Mendapatkan detail event lengkap berdasarkan ID
exports.getEventById = async (req, res) => {
    try {
        let event = await Event.findById(req.params.id)
            .populate('pendaftar', 'nama email nim')
            .populate('panitia', 'nama email');

        if (!event) {
            return res.status(404).json({ message: 'Event tidak ditemukan' });
        }

        // Update status otomatis
        const updatedEvent = updateEventStatus(event);
        if (event.status !== updatedEvent.status) {
            event.status = updatedEvent.status;
            await event.save();
        }

        res.status(200).json({
            message: 'Berhasil mendapatkan detail event',
            event
        });
    } catch (error) {
        res.status(500).json({
            message: 'Terjadi kesalahan server',
            error: error.message
        });
    }
};
