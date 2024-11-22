from flask import Flask, render_template, jsonify, request
from flask_cors import CORS
from train_model import train_model  # Ensure train_model is properly defined and imported

app = Flask(__name__)
CORS(app)  # Enable CORS for all routes

@app.route('/')
def home():
    return render_template('index.html')

@app.route('/train_model', methods=['POST'])
def train_model_route():
    try:
        # Call the train_model function from train_model.py
        accuracy = train_model()
        if accuracy is not None:
            # If training was successful, return the accuracy
            return jsonify({"message": f"Model trained successfully!"})
        else:
            # If there was an error, return an error message
            return jsonify({"error": "Model training failed."}), 500
    except Exception as e:
        # Log and handle any exceptions that may occur
        print(f"Error: {e}")
        return jsonify({"error": f"An error occurred: {str(e)}"}), 500

if __name__ == '__main__':
    app.run(port=5000, debug=True)
