const mongoose = require("mongoose");
const bookSchema = new mongoose.Schema({
  title: {
    type: String,
  },
  author: {
    type: String,
  },
  year: {
    type: Number,
  },
  pages: {
    type: Number,
  },
  summary: {
    type: String,
  },
  publisher: {
    type: String,
  },
});
module.exports = mongoose.model("book", bookSchema);
