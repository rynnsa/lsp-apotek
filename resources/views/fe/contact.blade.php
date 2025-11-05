
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h4 style="text-align: center; font-weight: lighter;" class="text-white">Yukk datang ke Apotek LifeCareYou! <br> atau gunakan informasi kontak di bawah ini untuk menghubungi kami</h4>
    </div>
    <!-- Single Page Header End -->

    <!-- Contact Start -->
    <div class="container-fluid contact py-5">
        <div class="container py-5">
            <div class="p-5 bg-light rounded">
                <div class="row g-4">
                    <div class="col-lg-12">
                        <div class="h-100 rounded">
                            <iframe class="rounded w-100" 
                                style="height: 400px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.9978019922396!2d106.8054667084079!3d-6.521958663728219!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c3db9bbedcc3%3A0x1f5280e86053b1e9!2sSMK%20NEGERI%201%20Cibinong!5e0!3m2!1sid!2sus!4v1745134800842!5m2!1sid!2sus" 
                                loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <form action="{{ route('contact.send') }}" method="POST" class="">
                            @csrf
                            <input type="text" name="name" class="w-100 form-control border-0 py-3 mb-4" placeholder="Nama Anda">
                            <input type="email" name="email" class="w-100 form-control border-0 py-3 mb-4" placeholder="Email Anda">
                            <textarea class="w-100 form-control border-0 mb-4" name="message" rows="5" cols="10" placeholder="Masukkan Pesan"></textarea>
                            <button class="w-100 btn form-control border-secondary py-3 bg-white text-primary" type="submit">Kirim Pesan</button>
                        </form>
                    </div>
                    <div class="col-lg-5">
                        <div class="d-flex p-4 rounded mb-4 bg-white">
                            <i class="fas fa-map-marker-alt fa-lg text-primary me-4" style="margin-top: 4px;"></i>
                            <div>
                                <h5>Alamat</h5>
                                <p class="mb-2"><a href="https://www.google.com/maps/place/SMK+NEGERI+1+Cibinong/@-6.5219587,106.8054667,17z/data=!3m1!4b1!4m6!3m5!1s0x2e69c3db9bbedcc3:0x1f5280e86053b1e9!8m2!3d-6.521964!4d106.808047!16s%2Fg%2F11c58r0rs1?entry=ttu&g_ep=EgoyMDI1MDQxNi4xIKXMDSoASAFQAw%3D%3D" target="_blank">Jl. Karadenan No.7, Karadenan, Cibinong, Karadenan, Cibinong, Bogor, Jawa Barat 16913, Indonesia.</a></p>
                            </div>
                        </div>
                        <div class="d-flex p-4 rounded mb-4 bg-white">
                            <i class="fas fa-envelope fa-lg text-primary me-4" style="margin-top: 4px;"></i>
                            <div>
                                <h5>Email</h5>
                                <p class="mb-2"><a href="mailto:alifecareyou@gmail.com" target="_blank">alifecareyou@gmail.com</a></p>
                            </div>
                        </div>
                        <div class="d-flex p-4 rounded bg-white">
                            <i class="fa fa-phone-alt fa-lg text-primary me-4" style="margin-top: 4px;"></i>
                            <div>
                                <h5>WhatsApp</h5>
                                <p class="mb-2"><a href="https://wa.me/6281234567890" target="_blank">(+62) 881 0104 58655</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->
