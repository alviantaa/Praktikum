require("dotenv").config();
const express = require("express");
const mongoose = require("mongoose");
const bookRoutes = require("./routes/book.route");
const app = express();

mongoose.connect(process.env.MONGO_URI);
const db = mongoose.connection;

db.on("error", (error) => {
  console.log(error);
});

db.once("connected", () => {
  console.log("Mongo connected");
});

app.use(express.json());
app.use("/books", bookRoutes);

app.get("/", (req, res) => {
  res.status(200).json({
    message: "<nama>,<nim>",
  });
});

const PORT = process.env.PORT || 8000;
app.listen(PORT, () => {
  console.log(`Running on port ${PORT}`);
});
