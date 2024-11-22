<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user/patient information
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $bp = $_POST['bp'];
    $temperature = $_POST['temperature'];
    
    // Initialize symptoms array
    $symptoms = array();
    
    // Common Symptoms
    if(isset($_POST['fever'])) $symptoms[] = 'fever';
    if(isset($_POST['headache'])) $symptoms[] = 'headache';
    if(isset($_POST['muscle_aches'])) $symptoms[] = 'muscle_aches';
    if(isset($_POST['joint_pain'])) $symptoms[] = 'joint_pain';
    
    // Respiratory Symptoms
    if(isset($_POST['runny_nose'])) $symptoms[] = 'runny_nose';
    if(isset($_POST['sneezing'])) $symptoms[] = 'sneezing';
    if(isset($_POST['shortness_of_breath'])) $symptoms[] = 'shortness_of_breath';
    if(isset($_POST['wheezing'])) $symptoms[] = 'wheezing';
    if(isset($_POST['asthma'])) $symptoms[] = 'asthma';
    if(isset($_POST['sinus_infection'])) $symptoms[] = 'sinus_infection';
    
    // Digestive Symptoms
    if(isset($_POST['heartburn'])) $symptoms[] = 'heartburn';
    if(isset($_POST['acid_reflux'])) $symptoms[] = 'acid_reflux';
    if(isset($_POST['stomach_pain'])) $symptoms[] = 'stomach_pain';
    
    // Query the database based on symptoms
    $symptom_list = implode("','", $symptoms);
    $sql = "SELECT DISTINCT d.* 
            FROM drugs d
            JOIN drug_symptoms ds ON d.drug_id = ds.drug_id
            JOIN symptoms s ON ds.symptom_id = s.symptom_id
            WHERE s.symptom_name IN ('$symptom_list')
            AND d.min_age <= $age 
            AND d.max_age >= $age";
    
    $result = $conn->query($sql);
    
    $recommendations = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $recommendations[] = array(
                'name' => $row['drug_name'],
                'dosage' => $row['dosage'],
                'precautions' => $row['precautions'],
                'side_effects' => $row['side_effects']
            );
        }
        echo json_encode(['status' => 'success', 'data' => $recommendations]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No recommendations found']);
    }
}
$conn->close();
?>