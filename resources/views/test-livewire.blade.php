<!DOCTYPE html>
<html>
<head>
    <title>Test Livewire</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="p-8">
    <h1 class="text-2xl mb-4">Test Livewire - Paso Actual: {{ $currentStep }}</h1>
    
    <livewire:clients.client-form />
    
    @livewireScripts
    
    <script>
        document.addEventListener('livewire:init', () => {
            console.log('Livewire initialized!');
        });
    </script>
</body>
</html>
