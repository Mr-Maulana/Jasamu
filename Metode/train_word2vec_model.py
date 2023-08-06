import gensim
from gensim.models import Word2Vec
from gensim.models.callbacks import CallbackAny2Vec
from gensim.test.utils import get_tmpfile
from gensim.models import KeyedVectors

def trainWord2VecModel():
    # Baca data kategori dari file categories.txt
    categories_file = 'categories.txt'
    with open(categories_file, 'r') as file:
        categories = file.read().splitlines()

    # Lakukan tokenisasi pada setiap kategori
    tokenized_categories = [category.split() for category in categories]

    # Pelatihan model Word2Vec
    model = Word2Vec(
        tokenized_categories,
        vector_size=100,  # Jumlah dimensi vektor representasi (100 contoh di sini)
        window=5,         # Ukuran jendela konteks
        min_count=1,      # Jumlah minimum kemunculan kata dalam korpus
        sg=1,             # Metode Skip-gram
        workers=4,        # Jumlah thread pelatihan
        epochs=100,       # Jumlah iterasi pelatihan
        compute_loss=True, # Menghitung loss pelatihan (opsional)
        callbacks=[EpochLogger()], # Callback untuk mencetak loss setiap epoch (opsional)
    )

    # Simpan model ke file
    model_file = 'word2vec_model.bin'
    model.wv.save_word2vec_format(model_file, binary=True)

    return model

class EpochLogger(CallbackAny2Vec):
    def __init__(self):
        self.epoch = 0

    def on_epoch_end(self, model):
        loss = model.get_latest_training_loss()
        print(f'Epoch {self.epoch}, Loss: {loss}')
        self.epoch += 1
