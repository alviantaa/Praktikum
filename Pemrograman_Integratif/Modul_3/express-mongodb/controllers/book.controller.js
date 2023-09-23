const Book = require("../models/book.model");
const router = require("express").Router();

async function getAllBooks(req, res) {
  try {
    const books = await Book.find();
    res.status(200).json({
      message: "mendapatkan semua buku",
      books,
    });
  } catch (error) {
    res.status(500).json({
      message: "kesalahan pada server",
      error: error.message,
    });
  }
}

async function getOneBook(req, res) {
  const id = req.params.id;
  try {
    const book = await Book.findById(id);
    res.status(200).json({
      message: "mendapatkan satu buku",
      book,
    });
  } catch (error) {
    res.status(500).json({
      message: "kesalahan pada server",
      error: error.message,
    });
  }
}

async function createBook(req, res) {
  const book = new Book({
    title: req.body.title,
    author: req.body.author,
    year: req.body.year,
    pages: req.body.pages,
    summary: req.body.summary,
    publisher: req.body.publisher,
  });
  try {
    const savedBook = await book.save();
    res.status(200).json({
      message: "membuat buku baru",
      book: savedBook,
    });
  } catch (error) {
    res.status(500).json({
      message: "kesalahan pada server",
      error: error.message,
    });
  }
}

async function updateBook(req, res) {
  const id = req.params.id;
  try {
    const book = await Book.findByIdAndUpdate(id, req.body, { new: true });
    res.status(200).json({
      message: "memperbaharui satu buku",
      book,
    });
  } catch (error) {
    res.status(500).json({
      message: "kesalahan pada server",
      error: error.message,
    });
  }
}

async function deleteBook(req, res) {
  const id = req.params.id;
  try {
    const book = await Book.findByIdAndDelete(id);
    res.status(200).json({
      message: "menghapus satu buku",
      book,
    });
  } catch (error) {
    res.status(500).json({
      message: "kesalahan pada server",
      error: error.message,
    });
  }
}

module.exports = {
  getAllBooks,
  getOneBook,
  createBook,
  updateBook,
  deleteBook,
};
