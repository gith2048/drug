import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.tree import DecisionTreeClassifier
from sklearn.metrics import accuracy_score

def train_model():
    try:
        print("Loading dataset...")
        # Load the dataset
        data = pd.read_csv('data/symptoms_diseases_medicines.csv')
        print(f"Dataset columns: {data.columns}")  # Print column names for debugging

        print("Preprocessing data...")
        # Identify the columns to use for training
        feature_cols = [
            'fatigue', 'weight_gain', 'cold_intolerance', 'sneezing', 'itchy_eyes',
            'runny_nose', 'shortness_of_breath', 'chest_pain', 'high_blood_pressure',
            'dry_mouth', 'dizziness', 'nausea', 'sore_throat', 'fever', 'headache',
            'muscle_aches', 'frequent_urination', 'weight_loss', 'blurred_vision',
            'pale_skin', 'anxiety', 'wheezing', 'chest_tightness', 'acid_reflux',
            'heartburn', 'stomach_pain', 'vomiting', 'constipation', 'diarrhea',
            'skin_rash', 'back_pain', 'palpitations', 'difficulty_swallowing'
        ]
        
        # Extract features and target variable
        X = data[feature_cols]
        y = data['Medicine']

        print("Splitting data into training and testing sets...")
        # Split the data into training and testing sets
        X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)
        print("Data split completed.")

        print("Training the model...")
        # Train the Decision Tree Classifier
        model = DecisionTreeClassifier(random_state=42)
        model.fit(X_train, y_train)
        print("Model training completed.")

        print("Evaluating the model...")
        y_pred = model.predict(X_test)
        accuracy = accuracy_score(y_test, y_pred)
        print(f"Model Accuracy: {accuracy * 100:.2f}%")

        return accuracy

    except Exception as e:
        print(f"Error: {e}")
        return None
