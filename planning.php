<?php 
session_start();
require_once 'db_config.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Travel Planning | Odyssey Travels</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .planning-body { padding: 40px; text-align: center; overflow-y: auto; height: 100vh; background-attachment: fixed; }
        
        .location-grid { 
            display: flex; 
            justify-content: center; 
            gap: 20px; 
            margin-top: 30px; 
            flex-wrap: wrap; /* Allows images to move to the next line if needed */
            max-width: 1300px;
            margin-left: auto;
            margin-right: auto;
        }

        .loc-card {
            width: 220px;
            cursor: pointer;
            transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border-radius: 15px;
            overflow: hidden;
            background: var(--glass);
            border: 1px solid rgba(255,255,255,0.1);
            position: relative;
        }

        .loc-card:hover { transform: translateY(-10px); border-color: var(--primary); box-shadow: 0 10px 20px rgba(0,0,0,0.3); }
        .loc-card img { width: 100%; height: 250px; object-fit: cover; filter: brightness(0.8); transition: 0.3s; }
        .loc-card:hover img { filter: brightness(1); }
        .loc-card h3 { padding: 12px; color: white; font-size: 1rem; background: rgba(0,0,0,0.5); position: absolute; bottom: 0; width: 100%; }

        #details-panel {
            margin-top: 40px;
            padding: 40px;
            background: white;
            color: #333;
            border-radius: 20px;
            display: none; 
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 15px 50px rgba(0,0,0,0.5);
            text-align: left;
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp { from { opacity: 0; transform: translateY(50px); } to { opacity: 1; transform: translateY(0); } }
        
        .detail-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        .close-btn { background: #e74c3c; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body class="planning-body">
    <a href="index.php" style="color: var(--primary); text-decoration: none; font-weight: 600;">← Back to Dashboard</a>
    
    <h1 style="color: white; margin-top: 20px; font-size: 2.5rem;">Select Your Destination</h1>
    <p style="color: #ccc; margin-bottom: 30px;">Choose a location to view detailed travel itineraries and highlights.</p>

    <div class="location-grid">
        <div class="loc-card" onclick="showDetails('Paris', 'Explore the Louvre, Eiffel Tower, and charming cafes of Montmartre. Perfect for art lovers.')">
            <img src="https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=400" alt="Paris">
            <h3>Paris</h3>
        </div>

        <div class="loc-card" onclick="showDetails('Bali', 'Tropical paradise with ancient temples, lush rice terraces, and world-class surfing beaches.')">
            <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=400" alt="Bali">
            <h3>Bali</h3>
        </div>

        <div class="loc-card" onclick="showDetails('Tokyo', 'A neon-lit metropolis blending futuristic technology with deep-rooted Japanese traditions.')">
            <img src="https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?auto=format&fit=crop&w=400" alt="Tokyo">
            <h3>Tokyo</h3>
        </div>

        <div class="loc-card" onclick="showDetails('Swiss Alps', 'Stunning mountain peaks, crystal clear lakes, and premium skiing resorts in Switzerland.')">
            <img src="https://images.unsplash.com/photo-1531310197839-ccf54634509e?auto=format&fit=crop&w=400" alt="Swiss Alps">
            <h3>Swiss Alps</h3>
        </div>

        <div class="loc-card" onclick="showDetails('China', 'Walk the Great Wall, visit the Forbidden City, and experience the rapid pace of Shanghai.')">
            <img src="https://images.unsplash.com/photo-1508804185872-d7badad00f7d?auto=format&fit=crop&w=400" alt="China">
            <h3>China</h3>
        </div>

        <div class="loc-card" onclick="showDetails('Thailand', 'Famous for ornate temples, tropical islands, and the bustling street food markets of Bangkok.')">
            <img src="thailand.webp" alt="Thailand">
            <h3>Thailand</h3>
        </div>

        <div class="loc-card" onclick="showDetails('Malaysia', 'Home to the Petronas Towers, colonial architecture, and the beautiful Batu Caves.')">
            <img src="malaysia.jpg" alt="Malaysia">
            <h3>Malaysia</h3>
        </div>

        <div class="loc-card" onclick="showDetails('Dubai', 'The city of gold features the Burj Khalifa, luxury shopping, and desert safari adventures.')">
            <img src="https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=400" alt="Dubai">
            <h3>Dubai</h3>
        </div>
    </div>

    <div id="details-panel">
        <div class="detail-header">
            <h2 id="detail-title" style="color: var(--primary);"></h2>
            <button class="close-btn" onclick="closeDetails()">Close</button>
        </div>
        <div style="display: flex; gap: 30px; margin-top: 20px;">
            <div style="flex: 2;">
                <h3>Destination Overview</h3>
                <p id="detail-text" style="line-height: 1.8; color: #555; margin-top: 10px;"></p>
                <div style="margin-top: 20px; padding: 15px; background: #f9f9f9; border-radius: 10px;">
                    <strong>Best Time to Visit:</strong> <span id="best-time">October to March</span><br>
                    <strong>Recommended Stay:</strong> <span id="stay-duration">5-7 Days</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showDetails(title, text) {
            const panel = document.getElementById('details-panel');
            document.getElementById('detail-title').innerText = title;
            document.getElementById('detail-text').innerText = text;
            
            // Logic to change best time based on country
            if(title === 'Dubai') document.getElementById('best-time').innerText = "November to April";
            else if(title === 'Thailand') document.getElementById('best-time').innerText = "November to February";
            else document.getElementById('best-time').innerText = "Varies by Season";

            panel.style.display = 'block';
            panel.scrollIntoView({ behavior: 'smooth' });
        }

        function closeDetails() {
            document.getElementById('details-panel').style.display = 'none';
        }
    </script>
</body>
</html>