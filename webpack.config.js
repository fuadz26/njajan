const path = require('path');

module.exports = {
  entry: './asssrc/index.js', // Ganti './src/index.js' dengan entri poin proyek Anda
  output: {
    path: path.resolve(__dirname, 'dist'), // Ganti 'dist' dengan direktori output yang diinginkan
    filename: 'bundle.js' // Nama file bundel output
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader'
        }
      },
      // Konfigurasi lainnya untuk menangani jenis file lain seperti CSS, gambar, dll.
    ]
  },
  resolve: {
    extensions: ['.js'] // Ekstensi file yang akan diresolve (misalnya, untuk import tanpa ekstensi)
  },
  devServer: {
    contentBase: path.resolve(__dirname, 'dist'), // Ganti 'dist' dengan direktori output yang diinginkan
    port: 8080, // Port yang akan digunakan oleh server pengembangan
    open: true // Buka browser secara otomatis ketika server berjalan
  }
};