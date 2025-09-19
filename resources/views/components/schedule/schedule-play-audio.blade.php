<div>
    // for more info see https://web.dev/articles/webaudio-intro
    <audio id="score-changed">
        <source src="{{ public_path('sound/bleep.mp3') }}" type="audio/mpeg" />
    </audio>

    <script>
        const bleep = document.getElementById('score-changed');

        function playAudio() {
            bleep.play();
        }
    </script>
</div>
