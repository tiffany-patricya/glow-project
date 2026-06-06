import sys
import json
import numpy as np
import tensorflow as tf
from PIL import Image
import os
import base64
import io

# Paksa Python pakai UTF-8 agar emoji dan HTML aman saat dikirim ke PHP
if sys.stdout.encoding.lower() != 'utf-8':
    sys.stdout.reconfigure(encoding='utf-8')

def main():
    try:
        if len(sys.argv) < 2:
            raise Exception("File path argumen hilang!")

        image_input_path = sys.argv[1]
        model_path = r"C:\xampp\htdocs\glow_exe\static\model\model.tflite"
        
        if not os.path.exists(model_path):
            raise Exception(f"File model tidak ditemukan di: {model_path}")

        interpreter = tf.lite.Interpreter(model_path=model_path)
        interpreter.allocate_tensors()
        
        with open(image_input_path, 'r') as f:
            base64_data = f.read()
        
        if ',' in base64_data:
            base64_data = base64_data.split(',')[1]
        
        img_data = base64.b64decode(base64_data)
        
        input_details = interpreter.get_input_details()
        output_details = interpreter.get_output_details()
        
        _, height, width, _ = input_details[0]['shape']
        input_type = input_details[0]['dtype']
        
        img = Image.open(io.BytesIO(img_data)).convert('RGB').resize((width, height))
        
        # KACAMATA YANG BENAR: Raw (0-255) tanpa pembagian
        img_array = np.expand_dims(np.array(img).astype(input_type), axis=0)
        
        interpreter.set_tensor(input_details[0]['index'], img_array)
        interpreter.invoke()
        
        preds = interpreter.get_tensor(output_details[0]['index'])[0]
        
        class_idx = int(np.argmax(preds))
        conf = float(preds[class_idx]) * 100
        
        classes = ["Mild 🟢", "Moderate 🟡", "Severe 🔴", "Very Severe 🟣"]
        
        # Penulisan solusi dibuat 1 baris per list agar 100% aman dari Syntax Error
        # Solusi versi Plain Text (Aman dari bentrok tag HTML)
        solusi = [
            " AI Skincare Plan: Ringan (Mild) |  Hero Ingredients: Salicylic Acid (BHA), Niacinamide, Centella Asiatica. |  Action Plan: Gunakan sabun cuci muka gentle. Pakai BHA maksimal 2x seminggu. Pilih pelembap bertekstur gel dan wajib Sunscreen Non-Comedogenic!",
            
            " AI Skincare Plan: Sedang (Moderate) |  Hero Ingredients: Benzoyl Peroxide, AHA/BHA, Tea Tree Oil. |  Action Plan: Totolkan obat jerawat (Benzoyl Peroxide) HANYA di titik jerawat pada malam hari. Gunakan serum Calming (Centella/Mugwort). Fokus ke pelembap Ceramide.",
            
            " AI Skincare Plan: Parah (Severe) |  Hero Ingredients: Retinoid (Adapalene), Azelaic Acid. |  Action Plan: Mulai perkenalkan Retinoid dari konsentrasi terendah (Night Routine). Jangan digabung AHA/BHA. Hindari physical scrub sama sekali!",
            
            " AI Medical Alert: Sangat Parah (Very Severe) |  Rekomendasi Medis: Pengobatan Resep Dokter. |  Action Plan: Stop pemakaian bahan aktif bebas (AHA/BHA/Retinol). Kembali ke Basic Skincare. AI mendeteksi inflamasi tinggi, segera konsultasikan ke Dokter Kulit (Sp.D.V.E)!"
        ]
        
        result = {
            "classification": classes[class_idx], 
            "confidence": f"{conf:.2f}%", 
            "solusi": solusi[class_idx]
        }
        
        # ensure_ascii=False agar karakter spesial/emoji bisa terkirim utuh
        print(json.dumps(result, ensure_ascii=False))
        
    except Exception as e:
        print(json.dumps({
            "classification": "Error Python", 
            "confidence": "0%", 
            "solusi": str(e)
        }))

if __name__ == "__main__":
    main()
