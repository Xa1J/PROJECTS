!pip install git+https://github.com/openai/whisper.git
!apt-get install -y ffmpeg
import whisper
from moviepy.editor import VideoFileClip
from google.colab import files

# Load Whisper model
model = whisper.load_model("small")

# Upload video
uploaded = files.upload()
video_path = list(uploaded.keys())[0]

# Extract audio
clip = VideoFileClip(video_path)
audio_path = "audio.wav"
clip.audio.write_audiofile(audio_path, codec='pcm_s16le')
clip.close()

# Transcribe
result = model.transcribe(audio_path)

# Save to text file
output_file = "transcription.txt"
with open(output_file, "w", encoding="utf-8") as f:
    f.write(result["text"])

# Download the file
files.download(output_file)
