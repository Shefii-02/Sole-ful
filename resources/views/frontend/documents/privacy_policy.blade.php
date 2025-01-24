@extends('layouts.app')


@push('header')
    <style>
        .documents h1,
        .documents h2 {
            font-size: 1.5rem;
        }

        .documents h3 {
            font-size: 1.2rem;
        }

        .documents p,
        .documents ul,
        .documents h1,
        .documents h2,
        .documents h3 {
            margin-bottom: 20px;
        }

        .documents ul {
            padding-left: 30px;
        }

        .documents ul li {
            list-style: disc !important;

        }
    </style>
@endpush

@section('content')
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area bg-img pt-12" data-bg="assets/img/banner/breadcrumb-banner.jpg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap text-center">
                        <nav aria-label="breadcrumb">
                            <h1 class="breadcrumb-title">Privacy Policy</h1>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Privacy Policy</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->
    <!-- page main wrapper start -->
    <div class="shop-main-wrapper section-padding documents">
        <div class="container">
            <div class="row">
                <div class="container py-4">

                    <p><strong>Effective Date:</strong> 1st Jan 2025</p>
                    <p>Soleful is committed to protecting your privacy. This Privacy Policy outlines how we collect, use,
                        disclose, and safeguard your information when you visit our website, <a
                            href="https://www.soleful.in" target="_blank">www.soleful.in</a>. By using our Site, you agree
                        to the terms of this Privacy Policy.</p>

                    <h2 class="mt-4">Information We Collect</h2>

                    <h3>Personal Information</h3>
                    <p>We may collect personal information you provide directly to us when you:</p>
                    <ul>
                        <li>Register an account on our Site.</li>
                        <li>Place an order for our products.</li>
                        <li>Subscribe to our newsletter or marketing communications.</li>
                        <li>Contact our customer support team.</li>
                    </ul>
                    <p>This information may include:</p>
                    <ul>
                        <li>Name</li>
                        <li>Email address</li>
                        <li>Phone number</li>
                        <li>Billing and shipping address</li>
                        <li>Payment details (processed securely through third-party payment gateways)</li>
                    </ul>

                    <h3>Non-Personal Information</h3>
                    <p>We may also collect non-personal information automatically when you use our Site, such as:</p>
                    <ul>
                        <li>Your IP address</li>
                        <li>Browser type and version</li>
                        <li>Pages you visit and time spent on the Site</li>
                        <li>Device type and operating system</li>
                    </ul>

                    <h2 class="mt-4">How We Use Your Information</h2>
                    <p>We use the information we collect for purposes including but not limited to:</p>
                    <ul>
                        <li>Processing and fulfilling your orders.</li>
                        <li>Managing your account and providing customer support.</li>
                        <li>Sending updates about your orders and promotional offers.</li>
                        <li>Improving our Site and personalizing your shopping experience.</li>
                        <li>Complying with legal and regulatory obligations.</li>
                    </ul>

                    <h2 class="mt-4">Sharing Your Information</h2>
                    <p>We may share your information with:</p>
                    <ul>
                        <li><strong>Service Providers:</strong> Third-party vendors who assist us with payment processing,
                            order fulfillment, and marketing.</li>
                        <li><strong>Legal Requirements:</strong> Authorities when required to comply with legal obligations
                            or to protect our rights.</li>
                        <li><strong>Business Transfers:</strong> As part of a business transaction, such as a merger or sale
                            of assets.</li>
                    </ul>

                    <h2 class="mt-4">Cookies and Tracking Technologies</h2>
                    <p>We use cookies and similar technologies to:</p>
                    <ul>
                        <li>Enhance your browsing experience.</li>
                        <li>Remember your preferences.</li>
                        <li>Analyze website traffic and performance.</li>
                    </ul>
                    <p>You can control or disable cookies through your browser settings, but note that some features of the
                        Site may not function properly without cookies.</p>

                    <h2 class="mt-4">Data Security</h2>
                    <p>We implement appropriate technical and organizational measures to protect your personal information
                        from unauthorized access, disclosure, alteration, or destruction. However, no method of transmission
                        over the internet or electronic storage is 100% secure.</p>

                    <h2 class="mt-4">Data Retention</h2>
                    <p>We will retain your personal information for as long as necessary to fulfill the purposes outlined in
                        this Privacy Policy unless a longer retention period is required or permitted by law.</p>

                    <h2 class="mt-4">Children's Privacy</h2>
                    <p>Our Site is not intended for individuals under the age of 18. We do not knowingly collect personal
                        information from children. If we become aware that a child under 18 has provided us with personal
                        information, we will take steps to delete it.</p>

                    <h2 class="mt-4">International Users</h2>
                    <p>If you are accessing our Site from outside India, please note that your information will be
                        transferred to and processed in India, where our servers are located. By using our Site, you consent
                        to this transfer.</p>

                    <h2 class="mt-4">Your Rights</h2>
                    <p>Depending on your location, you may have certain rights regarding your personal information,
                        including:</p>
                    <ul>
                        <li>Accessing, correcting, or deleting your information.</li>
                        <li>Opting out of marketing communications.</li>
                        <li>Restricting or objecting to the processing of your data.</li>
                    </ul>
                    <p>To exercise your rights, please contact us at <a
                            href="mailto:support@soleful.in">support@soleful.in</a>.</p>

                    <h2 class="mt-4">Third-Party Links</h2>
                    <p>Our Site may contain links to third-party websites. We are not responsible for the privacy practices
                        or content of these websites. We encourage you to review their privacy policies.</p>

                    <h2 class="mt-4">Changes to This Privacy Policy</h2>
                    <p>We may update this Privacy Policy from time to time. The updated version will be indicated by an
                        "Effective Date" at the top of this page. We encourage you to review this Privacy Policy
                        periodically.</p>

                    <h2 class="mt-4">Contact Us</h2>
                    <p>If you have any questions or concerns about this Privacy Policy, please contact us at:</p>
                    <ul>
                        <li><strong>Email:</strong> <a href="mailto:support@soleful.in">support@soleful.in</a></li>
                        <li><strong>Phone:</strong> +91 79 9666 6225</li>
                        <li><strong>Address:</strong><br>
                            No.5 Ground & 1st Floor, Hennur Main Road,<br>
                            Geddalahalli, Bangalore - 560077, India
                        </li>
                    </ul>

                    <p class="mt-4">Thank you for trusting Soleful. Your privacy is important to us.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
