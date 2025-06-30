        </main> <!-- Close main container from header -->

        <!-- Footer -->
        <footer class="bg-dark text-white py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mb-4 mb-lg-0">
                        <h5 class="mb-3">
                            <i class="fas fa-heartbeat me-2"></i>StudentHealthHub
                        </h5>
                        <p>Your comprehensive campus health solution, providing integrated healthcare services for students.</p>
                        <div class="social-icons">
                            <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 mb-4 mb-md-0">
                        <h5 class="mb-3">Quick Links</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="../index.php#home" class="text-white">Home</a></li>
                            <li class="mb-2"><a href="../index.php#services" class="text-white">Services</a></li>
                            <li class="mb-2"><a href="../index.php#appointments" class="text-white">Appointments</a></li>
                            <li class="mb-2"><a href="../index.php#resources" class="text-white">Resources</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                        <h5 class="mb-3">Services</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="#" class="text-white">General Consultation</a></li>
                            <li class="mb-2"><a href="#" class="text-white">Mental Health</a></li>
                            <li class="mb-2"><a href="#" class="text-white">Immunizations</a></li>
                            <li><a href="#" class="text-white">Wellness Programs</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3">
                        <h5 class="mb-3">Contact</h5>
                        <p><i class="fas fa-map-marker-alt me-2"></i> Student Health Center, University Campus</p>
                        <p><i class="fas fa-phone me-2"></i> (123) 456-7890</p>
                        <p><i class="fas fa-envelope me-2"></i> healthhub@university.edu</p>
                    </div>
                </div>
                <hr class="my-4">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start">
                        <p class="mb-0">&copy; <?php echo date('Y'); ?> StudentHealthHub. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <p class="mb-0">
                            <a href="privacy.php" class="text-white me-3">Privacy Policy</a>
                            <a href="terms.php" class="text-white">Terms of Service</a>
                        </p>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        <?php if (isset($custom_js)): ?>
        <!-- Page-specific JS -->
        <script src="<?php echo $custom_js; ?>"></script>
        <?php endif; ?>
    </body>
</html>