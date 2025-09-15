 tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        'casino-green': {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        },
                        'casino-gold': {
                            400: '#facc15',
                            500: '#eab308',
                        }
                    }
                }
            }
        }


 // Registration form functionality
        const registrationForm = document.getElementById('registrationForm');
        const registerBtns = [document.getElementById('registerBtn'), document.getElementById('registerBtn2')];
        const howItWorksBtn = document.getElementById('howItWorksBtn');
        const successMessage = document.getElementById('successMessage');
        const errorMessage = document.getElementById('errorMessage');

        // Scroll to form when register button is clicked
        registerBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                registrationForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
            });
        });

        // Scroll to how it works section
        howItWorksBtn.addEventListener('click', () => {
            document.querySelector('.bg-white.py-20').scrollIntoView({ behavior: 'smooth' });
        });

        // WhatsApp number formatting
        const whatsappInput = document.getElementById('whatsapp');
        whatsappInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
            
            if (value.startsWith('34')) {
                value = '+' + value;
            } else if (value.length === 9 && (value.startsWith('6') || value.startsWith('7'))) {
                value = '+34' + value;
            } else if (!value.startsWith('+') && value.length > 9) {
                value = '+' + value;
            }
            
            // Format Spanish numbers
            if (value.startsWith('+34') && value.length > 3) {
                const number = value.substring(3);
                if (number.length <= 9) {
                    value = '+34 ' + number.replace(/(\d{3})(\d{3})(\d{3})/, '$1 $2 $3').trim();
                }
            }
            
            e.target.value = value;
        });

        // Form submission
        registrationForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(registrationForm);
            const submitBtn = e.target.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.innerHTML = '⏳ Enviando...';
            submitBtn.disabled = true;
            
            try {
                const response = await fetch('mail.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.status === 'success') {
                    successMessage.classList.remove('hidden');
                    setTimeout(() => {
                        successMessage.classList.add('hidden');
                    }, 8000);
                    registrationForm.reset();
                } else {
                    throw new Error(result.message || 'Error al enviar');
                }
            } catch (error) {
                errorMessage.textContent = '❌ ' + (error.message || 'Error al enviar. Inténtalo de nuevo.');
                errorMessage.classList.remove('hidden');
                setTimeout(() => {
                    errorMessage.classList.add('hidden');
                }, 5000);
            } finally {
                // Restore button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });

        // Close messages on click
        successMessage.addEventListener('click', () => {
            successMessage.classList.add('hidden');
        });
        
        errorMessage.addEventListener('click', () => {
            errorMessage.classList.add('hidden');
        });

        // Simple form validation feedback
        const inputs = document.querySelectorAll('input[required]');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value.trim() === '') {
                    this.classList.add('border-red-300');
                    this.classList.remove('border-gray-300');
                } else {
                    this.classList.remove('border-red-300');
                    this.classList.add('border-gray-300');
                }
            });
        });