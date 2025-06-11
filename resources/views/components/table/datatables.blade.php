<table class="table table-striped w-100" id="{{ $id ?? 'datatable' }}">
    <thead>
        <tr>
            <th>No</th>
            @foreach ($headers as $header)
                <th>{{ $header }}</th>
            @endforeach
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($rows as $i => $row)
            <tr>
                <td>{{ $i + 1 }}</td>
                @foreach ($headers as $key)
                    <td>
                        @if ($key === 'Image')
                            @php
                                $image = $row[$key] ?? null;
                                $isUrl = $image && Str::startsWith($image, ['http://', 'https://']);
                                $imageUrl = $isUrl ? $image : asset('storage/' . $image);
                            @endphp
                            @if ($image)
                                <img src="{{ $imageUrl }}" alt="Image" style="max-height: 100px;">
                            @else
                                -
                            @endif
                        @else
                            {!! $row[$key] ?? '-' !!}
                        @endif
                    </td>
                @endforeach

                <td>
                    <x-table.edit-button :target="$row['data-target']" :action="$row['edit_url']" :data="$row['edit_data'] ?? []" />
                    <x-table.delete-button :url="$row['delete_url'] ?? '#'" label="Hapus" />
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="{{ count($headers) + 2 }}" class="text-center">Tidak ada data</td>
            </tr>
        @endforelse
    </tbody>
</table>
