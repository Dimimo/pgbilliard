<?php

use function Laravel\Folio\name;

name('privacy-policy');
?>

<x-layout>
    @volt
        <section>
            <x-title title="Privacy Policy" subtitle="Last updated: September 2025" />

            <div class="mb-6">
                The Puerto Galera Billiard League app ("the App") is a wrapper of our official
                website
                <a href="https://pgbilliard.com" class="link inline-block text-blue-800">
                    pgbilliard.com
                </a>
                . It provides access to our online billiard competition system.
            </div>

            <div class="mb-2 text-lg font-bold text-green-700">Information We Collect</div>
            <div class="mb-6 ml-4">
                The App itself does not collect any personal information. Any information you
                provide (such as your name, email, or competition scores) is submitted directly to
                <a href="https://pgbilliard.com" class="link inline-block text-blue-800">
                    pgbilliard.com
                </a>
                and handled under our website’s privacy policy.
            </div>

            <div class="mb-2 text-lg font-bold text-green-700">How We Use Information</div>
            <div class="mb-6 ml-4">
                Information provided on the website is used solely for managing billiard
                competitions and related league activities. We do not sell or share personal data
                with third parties.
            </div>

            <div class="mb-2 text-lg font-bold text-green-700">Third-Party Services</div>
            <div class="mb-6 ml-4">
                The App may load resources from our secure website only (
                <a href="https://pgbilliard.com" class="link inline-block text-blue-800">
                    pgbilliard.com
                </a>
                ). No external analytics or advertising services are embedded in the App.
            </div>

            <div class="mb-2 text-lg font-bold text-green-700">Security</div>
            <div class="mb-6 ml-4">
                All communication between the App and our website is encrypted using HTTPS.
            </div>

            <div class="mb-2 text-lg font-bold text-green-700">Contact Us</div>
            <div class="ml-4">
                If you have any questions about this Privacy Policy, please contact us at:
                <a href="mailto:info@pgbilliard.com" class="link inline-block text-blue-800">
                    info@pgbilliard.com
                </a>
            </div>
        </section>
    @endvolt
</x-layout>
