<script src="https://cdn.tailwindcss.com"></script>

<div class="bg-{{ $type === 'success' ? 'green' : 'red' }}-100 border border-{{ $type === 'success' ? 'green' : 'red' }}-400 text-{{ $type === 'success' ? 'green' : 'red' }}-700 px-4 py-3 rounded relative" role="alert">
    <strong class="font-bold">{{ ucfirst($type) }}!</strong>
    <span class="block sm:inline">{{ $message }}</span>
</div>