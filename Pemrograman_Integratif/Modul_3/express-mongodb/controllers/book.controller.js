const router = require("express").Router();

function getAllBooks(req, res) {
  res.status(200).json({
    message: "mendapatkan semua buku",
  });
}

function getOneBook(req, res) {
  const id = req.params.id;
  res.status(200).json({
    message: "mendapatkan satu buku",
    id,
  });
}

function createBook(req, res) {
  res.status(200).json({
    message: "membuat buku baru",
  });
}

function updateBook(req, res) {
  const id = req.params.id;
  res.status(200).json({
    message: "memperbaharui satu buku",
    id,
  });
}

function deleteBook(req, res) {
  const id = req.params.id;
  res.status(200).json({
    message: "menghapus satu buku",
    id,
  });
}

module.exports = {
  getAllBooks,
  getOneBook,
  createBook,
  updateBook,
  deleteBook,
};
