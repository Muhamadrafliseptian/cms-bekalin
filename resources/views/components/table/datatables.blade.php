<table class="table table-bordered table-striped w-100" id="{{ $id ?? 'datatable' }}">
    <thead>
        <tr>
            <th class="text-center">No</th>
            @foreach ($headers as $header)
                <th class="text-center">{{ $header }}</th>
            @endforeach
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rows as $i => $row)
            <tr>
                <td class="text-center align-middle">{{ $i + 1 }}</td>
                @foreach ($headers as $key)
                    <td class="text-center align-middle">
                        @if ($key === 'Image' || $key === 'Image Menu')
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
                <td class="text-center align-middle">
                    <x-table.edit-button
                        :target="$row['data-target'] ?? '#editModal'"
                        :action="$row['edit_url'] ?? '#'"
                        :data="$row['edit_data'] ?? []"
                    />
                    <x-table.delete-button
                        :url="$row['delete_url'] ?? '#'"
                        label="Hapus"
                    />
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
