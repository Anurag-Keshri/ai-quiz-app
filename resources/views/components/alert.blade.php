<style>
    .alert {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px;
        border-radius: 8px; /* Slightly larger border radius */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); /* Slightly deeper shadow */
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-width: 300px;
        max-width: 400px;
        color: #fff;
        font-weight: bold;
        transition: opacity 0.5s ease, transform 0.5s ease; /* Smooth transition */
        opacity: 1; /* Initially visible */
    }

    .alert-warning {
        background-color: #f0ad4e;
    }

    .alert-danger {
        background-color: #d9534f;
    }

    .alert-success {
        background-color: #5cb85c;
    }

    .alert .close-btn {
        background: none;
        border: none;
        color: #fff;
        font-size: 20px;
        cursor: pointer;
        margin-left: 15px; /* Space between message and close button */
        transition: color 0.3s; /* Transition for hover effect */
    }

    .alert .close-btn:hover {
        color: #ddd; /* Change color on hover */
    }

    /* Optional: Fade-out effect for alerts */
    .fade-out {
        opacity: 0;
        transform: translateY(-10px); /* Slide up slightly when fading out */
    }
</style>


@if (session('alert'))
    <div class="alert alert-warning" id="alert-warning" role="alert">
        {{ session('alert') }}
        <button class="close-btn" onclick="this.parentElement.style.display='none';">×</button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger" id="alert-danger" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button class="close-btn" onclick="this.parentElement.style.display='none';">×</button>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success" id="alert-success" role="alert">
        {{ session('success') }}
        <button class="close-btn" onclick="this.parentElement.style.display='none';">×</button>
    </div>
@endif
<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const alertWarning = document.getElementById('alert-warning');
            const alertDanger = document.getElementById('alert-danger');
            const alertSuccess = document.getElementById('alert-success');

            // Function to handle fading out
            function fadeOut(element) {
                if (element) {
                    element.classList.add('fade-out'); // Add fade-out class
                    setTimeout(() => {
                        element.style.display = 'none'; // Hide element after fade-out
                    }, 500); // Duration matches the CSS transition time
                }
            }

            fadeOut(alertWarning);
            fadeOut(alertDanger);
            fadeOut(alertSuccess);
        }, 5000); // 5 seconds
    });
</script>
