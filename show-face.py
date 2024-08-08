from flask import Flask, request, jsonify
import cv2
import numpy as np
import base64
from flask_cors import CORS

app = Flask(__name__)
CORS(app)

# Load the pre-trained face detector model
cascade_path = cv2.data.haarcascades + 'haarcascade_frontalface_default.xml'
face_cascade = cv2.CascadeClassifier(cascade_path)

if face_cascade.empty():
    raise IOError('Cannot load Haar cascade file from path: ' + cascade_path)

@app.route('/capture_face', methods=['POST'])
def capture_face():
    try:
        data = request.get_json()
        image_data = data['image']

        # Decode the base64 image
        image_data = base64.b64decode(image_data.split(",")[1])
        np_arr = np.frombuffer(image_data, np.uint8)
        frame = cv2.imdecode(np_arr, cv2.IMREAD_COLOR)

        # Convert the frame to grayscale (necessary for face detection)
        gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)

        # Detect faces in the frame
        faces = face_cascade.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=5, minSize=(30, 30))

        # Check if faces are found
        if len(faces) > 0:
            return jsonify({"status": "success", "message": "Face detected"})
        else:
            return jsonify({"status": "failure", "message": "No face detected"})
    except Exception as e:
        return jsonify({"status": "error", "message": str(e)})

if __name__ == '__main__':
    app.run(debug=True)
