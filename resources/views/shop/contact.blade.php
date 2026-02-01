@extends('layouts.modern')

@section('title', 'Contact Us - DreamyBloom')

@section('styles')
<style>
    .contact-hero {
        background: linear-gradient(135deg, rgba(155, 93, 143, 0.9), rgba(220, 145, 198, 0.9)), url('{{ asset('img/home_image.jpeg') }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        padding: 120px 0;
        text-align: center;
        position: relative;
    }
    .contact-hero h1 {
        font-size: 3.5rem;
        color: white;
        margin-bottom: 15px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }
    .contact-hero p {
        font-size: 1.2rem;
        color: white;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
    }
    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
    }
    .contact-form {
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    }
    .contact-form h2 {
        margin-bottom: 30px;
        color: var(--primary-color);
        font-size: 2rem;
    }
    .form-group {
        margin-bottom: 25px;
    }
    .form-group label {
        display: block;
        margin-bottom: 10px;
        font-weight: 600;
        color: var(--text-dark);
    }
    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 15px;
        border: 2px solid var(--border-color);
        border-radius: 10px;
        font-size: 1rem;
        transition: all 0.3s;
        font-family: 'Poppins', sans-serif;
    }
    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(155, 93, 143, 0.1);
    }
    .contact-info-card {
        display: flex;
        align-items: start;
        gap: 20px;
        padding: 25px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        transition: all 0.3s;
        margin-bottom: 20px;
    }
    .contact-info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }
    .contact-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .contact-icon i {
        color: white;
        font-size: 1.8rem;
    }
    .map-container {
        margin-top: 30px;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    }
    @media (max-width: 768px) {
        .contact-grid {
            grid-template-columns: 1fr;
        }
        .contact-hero h1 {
            font-size: 2.5rem;
        }
    }
</style>
@endsection

@section('content')

    <!-- Page Hero -->
    <section class="contact-hero">
        <h1> Get In Touch</h1>
        <p>We'd love to hear from you! Reach out to our friendly team</p>
    </section>

    <!-- Contact Section -->
    <section style="padding: 80px 0; background: var(--bg-light-pink);">
        <div class="container">
            <div class="contact-grid">
                <!-- Contact Form -->
                <div class="contact-form">
                    <h2> Send us a message</h2>
                    @if(session('success'))
                        <div class="alert-success" style="padding: 20px; background: linear-gradient(135deg, #d4edda, #c3e6cb); color: #155724; border-radius: 10px; margin-bottom: 25px; border-left: 4px solid #28a745;">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif
                    <form action="{{ route('shop.contact.submit') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name"><i class="fas fa-user"></i> Full Name *</label>
                            <input type="text" id="name" name="name" placeholder="Enter your full name" required>
                        </div>
                        <div class="form-group">
                            <label for="email"><i class="fas fa-envelope"></i> Email Address *</label>
                            <input type="email" id="email" name="email" placeholder="your.email@example.com" required>
                        </div>
                        <div class="form-group">
                            <label for="phone"><i class="fas fa-phone"></i> Phone Number</label>
                            <input type="tel" id="phone" name="phone" placeholder="+94 XX XXX XXXX">
                        </div>
                        <div class="form-group">
                            <label for="message"><i class="fas fa-comment-dots"></i> Your Message *</label>
                            <textarea id="message" name="message" rows="5" placeholder="Tell us how we can help you..." required></textarea>
                        </div>
                        <button type="submit" class="btn-primary" style="width: 100%; padding: 15px; font-size: 1.1rem;">
                            <i class="fas fa-paper-plane"></i> Send Message
                        </button>
                    </form>
                </div>

                <!-- Contact Information -->
                <div>
                    <h2 style="margin-bottom: 30px; font-size: 2rem; color: var(--primary-color);"> Contact Information</h2>
                    
                    <div class="contact-info-card">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h4 style="margin-bottom: 8px; font-size: 1.2rem; color: var(--primary-color);">Visit Us</h4>
                            <p style="color: var(--text-gray); line-height: 1.6;">No.63/5 Colombo Road<br>Kandy, Sri Lanka</p>
                        </div>
                    </div>

                    <div class="contact-info-card">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <h4 style="margin-bottom: 8px; font-size: 1.2rem; color: var(--primary-color);">Call Us</h4>
                            <p style="color: var(--text-gray); line-height: 1.6;">
                                <strong>+9411 2345 678</strong><br>
                                Mon-Sat: 9:00 AM - 6:00 PM
                            </p>
                        </div>
                    </div>

                    <div class="contact-info-card">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h4 style="margin-bottom: 8px; font-size: 1.2rem; color: var(--primary-color);">Email Us</h4>
                            <p style="color: var(--text-gray); line-height: 1.6;">
                                support@dreamybloom.lk<br>
                                info@dreamybloom.lk
                            </p>
                        </div>
                    </div>

                    <div class="contact-info-card">
                        <div class="contact-icon">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <div>
                            <h4 style="margin-bottom: 8px; font-size: 1.2rem; color: var(--primary-color);">WhatsApp</h4>
                            <p style="color: var(--text-gray); line-height: 1.6;">
                                <strong>+94 77 123 4567</strong><br>
                                Quick support via WhatsApp
                            </p>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div style="margin-top: 30px; padding: 30px; background: white; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                        <h4 style="margin-bottom: 20px; color: var(--primary-color); font-size: 1.2rem;"> Follow Us</h4>
                        <div style="display: flex; gap: 15px;">
                            <a href="#" style="width: 50px; height: 50px; background: linear-gradient(135deg, #405DE6, #5851DB); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; transition: all 0.3s; text-decoration: none;">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" style="width: 50px; height: 50px; background: linear-gradient(135deg, #833AB4, #FD1D1D); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; transition: all 0.3s; text-decoration: none;">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" style="width: 50px; height: 50px; background: linear-gradient(135deg, #1DA1F2, #0A66C2); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; transition: all 0.3s; text-decoration: none;">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" style="width: 50px; height: 50px; background: linear-gradient(135deg, #25D366, #128C7E); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; transition: all 0.3s; text-decoration: none;">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section (Optional) -->
    <section style="padding: 60px 0; background: var(--bg-light-pink);">
        <div class="container">
            <h2 style="text-align: center; margin-bottom: 40px;">Find Us</h2>
            <div style="border-radius: 15px; overflow: hidden; box-shadow: var(--shadow);">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.5!2d80.6!3d7.3!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMTgnMDAuMCJOIDgwwrAzNicwMC4wIkU!5e0!3m2!1sen!2slk!4v1234567890" 
                    width="100%" 
                    height="400" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </div>
    </section>

@endsection
