document.addEventListener('DOMContentLoaded', function() {
    // Theme Toggle Functionality
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = themeToggle.querySelector('i');
    const themeText = themeToggle.querySelector('span');
    const html = document.documentElement;
    
    // Initialize theme
    function initTheme() {
        const savedTheme = localStorage.getItem('theme') || 
                         (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        
        if (savedTheme === 'dark') {
            html.setAttribute('data-bs-theme', 'dark');
            themeIcon.classList.replace('fa-moon', 'fa-sun');
            themeText.textContent = 'Light Mode';
        } else {
            html.setAttribute('data-bs-theme', 'light');
            themeIcon.classList.replace('fa-sun', 'fa-moon');
            themeText.textContent = 'Dark Mode';
        }
    }
    
    // Toggle theme
    function toggleTheme() {
        if (html.getAttribute('data-bs-theme') === 'dark') {
            html.setAttribute('data-bs-theme', 'light');
            localStorage.setItem('theme', 'light');
            themeIcon.classList.replace('fa-sun', 'fa-moon');
            themeText.textContent = 'Dark Mode';
        } else {
            html.setAttribute('data-bs-theme', 'dark');
            localStorage.setItem('theme', 'dark');
            themeIcon.classList.replace('fa-moon', 'fa-sun');
            themeText.textContent = 'Light Mode';
        }
    }
    
    // Initialize on load
    initTheme();
    
    // Add event listener
    themeToggle.addEventListener('click', toggleTheme);
    
    // Watch for system theme changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
        if (!localStorage.getItem('theme')) {
            initTheme();
        }
    });

    // Generate sample time slots
    function generateTimeSlots() {
        const container = document.getElementById('timeSlotsContainer');
        container.innerHTML = '';
        
        const startHour = 9;
        const endHour = 16;
        const slotsPerHour = 2;
        
        for (let hour = startHour; hour <= endHour; hour++) {
            for (let slot = 0; slot < slotsPerHour; slot++) {
                const minutes = slot === 0 ? '00' : '30';
                const time = `${hour}:${minutes}`;
                
                // Randomly mark some slots as booked (for demo)
                const isBooked = Math.random() < 0.3;
                
                const timeSlot = document.createElement('div');
                timeSlot.className = `col-6 col-md-4 col-lg-3 time-slot ${isBooked ? 'booked' : ''}`;
                timeSlot.textContent = time;
                
                if (!isBooked) {
                    timeSlot.addEventListener('click', function() {
                        document.querySelectorAll('.time-slot').forEach(slot => {
                            slot.classList.remove('selected');
                        });
                        this.classList.add('selected');
                        document.getElementById('appointmentTime').value = time;
                    });
                }
                
                container.appendChild(timeSlot);
            }
        }
    }
    
    // Load upcoming appointments
    function loadUpcomingAppointments() {
        // In a real app, this would fetch from the server
        const appointments = [
            {
                service_type: "General Consultation",
                appointment_date: "2023-06-25",
                appointment_time: "10:30",
                doctor: "Dr. Sarah Johnson",
                status: "scheduled"
            },
            {
                service_type: "Mental Health",
                appointment_date: "2023-07-02",
                appointment_time: "14:00",
                doctor: "Dr. Michael Brown",
                status: "scheduled"
            }
        ];
        
        const container = document.getElementById('upcomingAppointments');
        container.innerHTML = '';
        
        if (appointments.length === 0) {
            container.innerHTML = '<div class="list-group-item text-center py-4 text-muted">No upcoming appointments</div>';
            return;
        }
        
        appointments.forEach(appointment => {
            const item = document.createElement('div');
            item.className = 'list-group-item fade-in';
            item.innerHTML = `
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">${appointment.service_type}</h5>
                    <small class="text-muted">${new Date(appointment.appointment_date).toLocaleDateString()}</small>
                </div>
                <p class="mb-1"><i class="fas fa-clock me-1"></i> ${appointment.appointment_time}</p>
                <small class="text-muted"><i class="fas fa-user-md me-1"></i> ${appointment.doctor}</small>
                <span class="badge ${getStatusBadge(appointment.status)} float-end mt-1">${appointment.status}</span>
            `;
            container.appendChild(item);
        });
    }
    
    function getStatusBadge(status) {
        switch (status.toLowerCase()) {
            case 'scheduled': return 'bg-primary';
            case 'completed': return 'bg-success';
            case 'cancelled': return 'bg-danger';
            case 'no-show': return 'bg-warning';
            default: return 'bg-secondary';
        }
    }

    // Form submission handlers
    document.getElementById('appointmentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('php/store_appointment.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.success) {
                this.reset();
                document.querySelectorAll('.time-slot.selected').forEach(slot => {
                    slot.classList.remove('selected');
                });
                loadUpcomingAppointments();
                generateTimeSlots();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while booking the appointment');
        });
    });

    document.getElementById('contactForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('php/store_contact.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.success) {
                this.reset();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while sending your message');
        });
    });

    // Set minimum date for appointment to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('appointmentDate').min = today;

    // Initialize time slots and appointments
    generateTimeSlots();
    loadUpcomingAppointments();

    // Smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 70,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Add animation to elements when they come into view
    const animateOnScroll = function() {
        const elements = document.querySelectorAll('.service-card, .resource-card, .section-title');
        
        elements.forEach(element => {
            const elementPosition = element.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;
            
            if (elementPosition < windowHeight - 100) {
                element.classList.add('fade-in');
            }
        });
    };
    
    window.addEventListener('scroll', animateOnScroll);
    animateOnScroll(); // Run once on page load
});