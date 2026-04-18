<x-app-layout>
    <div class="container mx-auto px-4">
        <!-- Create Blog Button -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">📜 Blog Posts</h2>
            <a href="{{ route('blog.create') }}"
                class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow-md hover:bg-blue-700 transition">
                ➕ Create New Blog
            </a>
        </div>

        <!-- Blog Table -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <table class="w-full border-collapse">
                <thead class="bg-gray-200 text-gray-700 uppercase text-sm">
                    <tr>
                        <th class="px-4 py-3 text-left">ID</th>
                        <th class="px-4 py-3 text-left">Title</th>
                        <th class="px-4 py-3 text-left">Description</th>
                        <th class="px-4 py-3 text-left">Created At</th>
                        <th class="px-4 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($blogs as $item)
                        <tr class="hover:bg-gray-100 transition">
                            <td class="px-4 py-3">{{ $item->id }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-900">{{ $item->title }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ Str::limit($item->description, 45) }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $item->created_at->format('d M, Y') }}</td>
                            <td class="px-4 py-3 flex justify-center space-x-2">
                                <a href="{{ route('blog.show', $item) }}"
                                    class="px-3 py-1 bg-blue-500 text-white text-xs font-semibold rounded shadow-md hover:bg-blue-600 transition">
                                    👁 View
                                </a>
                                <a href="{{ route('blog.edit', $item) }}"
                                    class="px-3 py-1 bg-yellow-500 text-white text-xs font-semibold rounded shadow-md hover:bg-yellow-600 transition">
                                    ✏️ Edit
                                </a>
                                <form method="post" action="{{route("blog.destroy", $item)}}">
                                    @csrf
                                    @method("delete")
                                    <button onclick="return confirm('Tem certeza que quer eliminar o blog?')"
                                        class="px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded shadow-md hover:bg-red-600 transition">
                                        🗑 Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-center">
            {{-- <button class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg">Previous</button>
            <button class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg ml-2">Next</button> --}}
            {{ $blogs->links() }}
        </div>
    </div>
</x-app-layout>
