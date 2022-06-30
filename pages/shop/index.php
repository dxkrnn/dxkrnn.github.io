<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Welcome! - Nio Furniture</title>
        <link rel="stylesheet" href="style.css">
        <link rel="shortcut icon" type="image/x-icon" href="../../assets/favicon.png">
    </head>
    <body>
        <section>
            <div class="circle"></div>
            <header>
                <a href="#"><image src="../../assets/logo.png" class="logo"></a>
                <div class="toggle" onclick="toggleMenu()"></div>    
                <ul class="navigation">
                    <li><a href="../../index.html">Home</a></li>
                    <li><a href="#" class="activePage">Shop</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="../../signin-signup/logout.php">Logout</a></li>
                </ul>
            </header>
            <div class="content">
                <div class="textBox">
                    <h2>We are<br><span>Coming Soon</span></h2>
                    <p>
                        Temukan berbagai furniture cantik, jadikan rumah Anda lebih aesthetic, dan buat tetangga makin melirik. <b>Nantikan Kami!</b> 
                    </p>

                    <!-- COUNT DOWN -->
                    <div id="countdown">
                        <ul>
                        <li><span id="days"></span>days</li>
                        <li><span id="hours"></span>Hours</li>
                        <li><span id="minutes"></span>Minutes</li>
                        <li><span id="seconds"></span>Seconds</li>
                        </ul>
                    </div>
                    <a href="#notify_me" data-toggle="modal" data-target="#notify_me">Notify Me</a>
                </div>
                <div class="imgBox">
                    <img src="../../assets/img1.png" class="starbucks">
                </div>
            </div>

            <ul class="thumb">
                <li><img src="../../assets/thumb1.png" onclick="imgSlider('../../assets/img1.png'); changeCricleColor('#D0C7C5')"></li>
                <li><img src="../../assets/thumb2.png" onclick="imgSlider('../../assets/img2.png'); changeCricleColor('#676775')"></li>
                <li><img src="../../assets/thumb3.png" onclick="imgSlider('../../assets/img3.png'); changeCricleColor('#D0C7C5')"></li>
            </ul>
            <ul class="sci">
                <li><a href="#"><img src="../../assets/facebook.png"></a></li>
                <li><a href="#"><img src="../../assets/twitter.png"></a></li>
                <li><a href="#"><img src="../../assets/instagram.png"></a></li>
            </ul>
        </section>

        <script type="text/javascript">
            function imgSlider(anything) {
                document.querySelector('.starbucks').src = anything;
            }

            function changeCricleColor(color) {
                const circle = document.querySelector('.circle');
                circle.style.background = color;
            }

            function toggleMenu() {
                var menuToggle = document.querySelector('.toggle');
                var navigation = document.querySelector('.navigation')
                menuToggle.classList.toggle('active')
                navigation.classList.toggle('active')
            }
        </script>

        <script>
            (function () {
                const second = 1000,
                    minute = second * 60,
                    hour = minute * 60,
                    day = hour * 24;

                let today = new Date(),
                    dd = String(today.getDate()).padStart(2, "0"),
                    mm = String(today.getMonth() + 1).padStart(2, "0"),
                    yyyy = today.getFullYear(),
                    nextYear = yyyy + 1,
                    dayMonth = "07/07/",
                    releaseDate = dayMonth + yyyy;
                
                today = mm + "/" + dd + "/" + yyyy;
                if (today > releaseDate) {
                    releaseDate = dayMonth + nextYear;
            }
            
            //end
            
            const countDown = new Date(releaseDate).getTime(),
                x = setInterval(function() {    

                    const now = new Date().getTime(),
                        distance = countDown - now;

                    document.getElementById("days").innerText = Math.floor(distance / (day)),
                    document.getElementById("hours").innerText = Math.floor((distance % (day)) / (hour)),
                    document.getElementById("minutes").innerText = Math.floor((distance % (hour)) / (minute)),
                    document.getElementById("seconds").innerText = Math.floor((distance % (minute)) / second);

                    //do something later when date is reached
                    if (distance < 0) {
                    document.getElementById("headline").innerText = "Heyo, Nio Furniture is Coming!";
                    document.getElementById("countdown").style.display = "none";
                    document.getElementById("content").style.display = "block";
                    clearInterval(x);
                    }
                    //seconds
                }, 0)
            }());
        </script>

    </body>
</html>