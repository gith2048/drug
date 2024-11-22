const express = require('express');
const mongoose = require('mongoose');
const bodyParser = require('body-parser');
const User = require('./user');
const DrugHistory = require('./drugHistory');
const jwt = require('jsonwebtoken');

const app = express();
app.use(bodyParser.json());


mongoose.connect('mongodb://localhost:27017/drug-recommendation', { useNewUrlParser: true, useUnifiedTopology: true });


app.post('/register', async (req, res) => {
  try {
    const { username, password } = req.body;
    const user = new User({ username, password });
    await user.save();
    res.status(201).send('User registered successfully');
  } catch (error) {
    res.status(500).send(error.message);
  }
});

app.post('/login', async (req, res) => {
  try {
    const { username, password } = req.body;
    const user = await User.findOne({ username });
    if (!user || !(await user.comparePassword(password))) {
      return res.status(401).send('Invalid credentials');
    }
    const token = jwt.sign({ id: user._id }, 'secretKey', { expiresIn: '1h' });
    res.json({ token });
  } catch (error) {
    res.status(500).send(error.message);
  }
});

app.post('/drug_history', async (req, res) => {
  try {
    const { patientId, drug } = req.body;
    const drugHistory = new DrugHistory({ patientId, drug });
    await drugHistory.save();
    res.status(201).send('Drug history added successfully');
  } catch (error) {
    res.status(500).send(error.message);
  }
});

app.get('/drug_history/:patientId', async (req, res) => {
  try {
    const { patientId } = req.params;
    const histories = await DrugHistory.find({ patientId });
    res.json(histories);
  } catch (error) {
    res.status(500).send(error.message);
  }
});

const Drug = require('./drug');


// Add a new drug
app.post('/drugs', async (req, res) => {
  try {
    const { name, description, sideEffects, dosage, interactions } = req.body;
    const drug = new Drug({ name, description, sideEffects, dosage, interactions });
    await drug.save();
    res.status(201).json(drug);
  } catch (error) {
    res.status(500).send(error.message);
  }
});

// Get all drugs
app.get('/drugs', async (req, res) => {
  try {
    const drugs = await Drug.find();
    res.json(drugs);
  } catch (error) {
    res.status(500).send(error.message);
  }
});

// Get a specific drug
app.get('/drugs/:name', async (req, res) => {
  try {
    const drug = await Drug.findOne({ name: req.params.name });
    if (!drug) {
      return res.status(404).send('Drug not found');
    }
    res.json(drug);
  } catch (error) {
    res.status(500).send(error.message);
  }
});

// Update a drug
app.put('/drugs/:name', async (req, res) => {
  try {
    const drug = await Drug.findOneAndUpdate({ name: req.params.name }, req.body, { new: true });
    if (!drug) {
      return res.status(404).send('Drug not found');
    }
    res.json(drug);
  } catch (error) {
    res.status(500).send(error.message);
  }
});

// Delete a drug
app.delete('/drugs/:name', async (req, res) => {
  try {
    const drug = await Drug.findOneAndDelete({ name: req.params.name });
    if (!drug) {
      return res.status(404).send('Drug not found');
    }
    res.send('Drug deleted successfully');
  } catch (error) {
    res.status(500).send(error.message);
  }
});

app.listen(3000, () => {
  console.log('Server is running on port 3000');
});
