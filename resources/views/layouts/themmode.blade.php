{{-- @section('themmode') --}}
<div class="d-flex" title="حالت شب">
    <img id="mode-icon" src="https://static.ketab.tv/ketab-tv-static/front/images/svg/On_light.svg" alt="حالت شب" class="menu-svg me-2" />

    <span class="a-color a-light-mode a-dark-mode me-2">حالت شب</span>

    <label class="form-switch">
        <input class="form-check-input" type="checkbox" role="switch" id="darkModeToggle" onchange="toggleDarkMode()" />
        <span class="slider"></span>
    </label>
</div>

<style>
    body.dark-mode {
        background-color: #121212;
        color: #f0f0f0;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    /* Add your existing CSS classes here */
    .d-flex {
        display: flex;
        align-items: center;
    }

    .me-2 {
        margin-left: 0.5rem;
    }

    .menu-svg {
        width: 32px;
        height: 32px;
    }

    .form-switch {
        position: relative;
        display: inline-block;
        width: 40px;
        height: 22px;
    }

    .form-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .form-check-input {
        cursor: pointer;
    }

    .form-switch input + .slider {
        position: absolute;
        cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 22px;
    }

    .form-switch input:checked + .slider {
        background-color: #2196F3;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 2px;
        bottom: 2px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    .form-switch input:checked + .slider:before {
        transform: translateX(18px);
    }
</style>

<script>
    function toggleDarkMode() {
        const body = document.body;
        const icon = document.getElementById('mode-icon');
        const toggle = document.getElementById('darkModeToggle');
        const isDark = toggle.checked;

        if (isDark) {
            body.classList.add('dark-mode');
            icon.src = "https://static.ketab.tv/ketab-tv-static/front/images/svg/On_dark.svg";
        } else {
            body.classList.remove('dark-mode');
            icon.src = "https://static.ketab.tv/ketab-tv-static/front/images/svg/On_light.svg";
        }

        localStorage.setItem('darkMode', isDark ? 'enabled' : 'disabled');
    }

    window.addEventListener('DOMContentLoaded', () => {
        const darkMode = localStorage.getItem('darkMode');
        const toggle = document.getElementById('darkModeToggle');
        const icon = document.getElementById('mode-icon');

        if (darkMode === 'enabled') {
            document.body.classList.add('dark-mode');
            toggle.checked = true;
            icon.src = "https://static.ketab.tv/ketab-tv-static/front/images/svg/On_dark.svg";
        }
    });
</script>
{{-- @endsection --}}
