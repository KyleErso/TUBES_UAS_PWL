// Import modul yang diperlukan
const express   = require('express');
const cors      = require('cors');
const dotenv    = require('dotenv');
const mongoose  = require('mongoose');
const path      = require('path');

// Import routes
const authRoutes  = require('./routes/auth');
const eventRoutes = require('./routes/events');

// UNTUK JALANIN SEMUA CRUD DI DASHBOARD
const dashboardRoutes = require('./routes/dashboard');

// Konfigurasi environment variables
dotenv.config({ path: path.join(__dirname, '.env') });

// Inisialisasi aplikasi Express
const app = express();

// Konfigurasi port
const PORT = process.env.PORT || 5001;

// Middleware (bisa dipakai sebelum atau sesudah koneksi, tidak masalah)
app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Koneksi ke MongoDB dengan opsi yang lebih lengkap
const MONGODB_URI = process.env.MONGODB_URI || 'mongodb://localhost:27017/event-app';
mongoose.connect(MONGODB_URI, {
  useNewUrlParser: true,
  useUnifiedTopology: true,
  serverSelectionTimeoutMS: 5000,
  socketTimeoutMS: 45000
})
.then(() => {
  console.log('Terhubung ke MongoDB');
  // Pastikan koneksi berhasil sebelum menjalankan server
  app.listen(PORT, () => {
    console.log(`Server berjalan di port ${PORT}`);
  });
})
.catch(err => {
  console.error('Kesalahan koneksi MongoDB:', err);
  process.exit(1);
});

// Routes
app.use('/api/auth', authRoutes);
app.use('/api/events', eventRoutes);
app.use('/api/dashboard', dashboardRoutes);







