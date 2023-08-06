import fileinput
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.cluster import KMeans
import requests

# Daftar kategori
categories = __file__('storage/app/category.txt') # Ganti dengan daftar kategori yang sesuai

# Input dari pengguna
input_jasa = "nama jasa yang dimasukkan oleh pengguna"  # Ganti dengan input yang sesuai

# Preprocessing input
input_words = input_jasa.lower().split()

# Gabungkan input dengan daftar kategori
words = input_words + categories

# TF-IDF Vectorization
vectorizer = TfidfVectorizer()
tfidf_matrix = vectorizer.fit_transform(words)

# K-Means Clustering
num_clusters = len(categories)
kmeans = KMeans(n_clusters=num_clusters)
kmeans.fit(tfidf_matrix)

# Dapatkan cluster yang sesuai dengan input
input_cluster = kmeans.predict(vectorizer.transform([input_jasa]))

# Dapatkan kategori dari cluster yang sesuai
recommendation = [categories[i] for i, label in enumerate(kmeans.labels_) if label == input_cluster[0]]

# Kirim hasil rekomendasi ke server Laravel
payload = {'recommendation': recommendation}
response = requests.post('http://localhost:8000/api/recommendation', data=payload)
