const mongoose = require('mongoose');

const drugHistorySchema = new mongoose.Schema({
  patientId: { type: String, required: true },
  drug: { type: String, required: true },
  timestamp: { type: Date, default: Date.now }
});

module.exports = mongoose.model('DrugHistory', drugHistorySchema);
