<div>
    <form wire:submit.prevent="calculateRecommendation">
        <label for="inputJasa">Masukkan Nama Jasa:</label>
        <input type="text" wire:model="inputJasa">
        <button type="submit">Cari Rekomendasi Kategori</button>
    </form>

    @if ($recommendation)
        <div>
            <h3>Rekomendasi Kategori:</h3>
            <ul>
                @foreach ($recommendation as $category)
                    <li>{{ $category }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
