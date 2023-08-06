def recommendCategory(model, service_name):
    # Lakukan tokenisasi pada nama jasa yang dimasukkan oleh pengguna
    tokenized_service_name = service_name.split()

    # Ambil vektor representasi dari setiap kata dalam nama jasa
    word_vectors = [model.wv[word] for word in tokenized_service_name if word in model.wv]

    # Lakukan average dari vektor kata-kata untuk mendapatkan vektor representasi nama jasa
    if word_vectors:
        service_vector = sum(word_vectors) / len(word_vectors)
    else:
        # Jika nama jasa tidak ada dalam model, kembalikan kategori default
        return "Everything Else"

    # Cari kategori yang paling mirip dengan vektor representasi nama jasa
    similar_categories = model.wv.similar_by_vector(service_vector, topn=3)

    # Ambil kategori dengan kemiripan tertinggi sebagai rekomendasi kategori
    recommended_category = similar_categories[0][0]

    return recommended_category
