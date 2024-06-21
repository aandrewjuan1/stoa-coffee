<button @click="darkMode = !darkMode; localStorage.setItem('theme', darkMode ? 'dark' : 'light')" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition duration-150 ease-in-out ml-4">
    <i :class="darkMode ? 'fas fa-sun' : 'fas fa-moon'"></i>
</button>