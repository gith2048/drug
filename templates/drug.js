const mongoose = require('mongoose');

const drugSchema = new mongoose.Schema({
  name: { type: String, required: true, unique: true },
  description: { type: String, required: true },
  sideEffects: [String],
  dosage: String,
  interactions: [String]
});

module.exports = mongoose.model('Drug', drugSchema);