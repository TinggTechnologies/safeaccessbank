from flask import Flask, request, jsonify
import cv2
import numpy as np
import os
import time
import base64
from flask_cors import CORS

app = Flask(__name__)
CORS(app)

# Load the pre-trained face detector model
cascade_path = cv2.data.haarcascades + 'haarcascade_frontalface_default.xml'
face_cascade = cv2.CascadeClassifier(cascade_path)

if face_cascade.empty():
    raise IOError('Cannot load Haar cascade file from path: ' + cascade_path)

# Directory to save captured faces
if not os.path.exists('captured_faces'):
    os.makedirs('captured_faces')

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

        # If faces are found, save the first face
        if len(faces) > 0:
            (x, y, w, h) = faces[0]
            face = frame[y:y+h, x:x+w]
            face_filename = f"captured_faces/face_{int(time.time())}.jpg"
            cv2.imwrite(face_filename, face)
            return jsonify({"status": "success", "message": "Face captured and saved.", "filename": face_filename})
        else:
            return jsonify({"status": "failure", "message": "No face detected."})
    except Exception as e:
        return jsonify({"status": "error", "message": str(e)})

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)
