<?php 
session_start();
if (!isset($_SESSION['user'])) { header("Location: index.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vehicles & Guides | Odyssey Travels</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .vg-container { padding: 50px; max-width: 1200px; margin: auto; color: white; height: 100vh; overflow-y: auto; }
        
        /* Tab Styling */
        .tabs { display: flex; justify-content: center; gap: 20px; margin-bottom: 40px; }
        .tab-btn { 
            background: rgba(255,255,255,0.1); border: 2px solid transparent; color: white; 
            padding: 10px 30px; border-radius: 30px; cursor: pointer; font-weight: 600; transition: 0.3s;
        }
        .tab-btn.active { background: var(--primary); border-color: var(--primary); }

        .content-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px; }
        
        .vg-card { 
            background: var(--glass); border-radius: 15px; overflow: hidden; 
            border: 1px solid rgba(255,255,255,0.1); transition: 0.3s; 
        }
        .vg-card:hover { transform: translateY(-5px); border-color: var(--primary); }
        .vg-card img { width: 100%; height: 200px; object-fit: cover; }
        .vg-info { padding: 20px; }
        
        .badge { background: var(--primary); font-size: 12px; padding: 3px 10px; border-radius: 5px; margin-bottom: 10px; display: inline-block; }
        .hidden { display: none; }
    </style>
</head>
<body>
    <div class="vg-container">
        <a href="index.php" style="color: var(--primary); text-decoration: none;">← Back to Home</a>
        <h1 style="text-align: center; margin: 20px 0;">Our Fleet & Experts</h1>

        <div class="tabs">
            <button class="tab-btn active" onclick="switchTab('vehicles')">Our Vehicles</button>
            <button class="tab-btn" onclick="switchTab('guides')">Certified Guides</button>
        </div>

        <div id="vehicles-section" class="content-grid">
            <div class="vg-card">
                <img src="https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=500" alt="Luxury SUV">
                <div class="vg-info">
                    <span class="badge">Premium</span>
                    <h3>Luxury SUV</h3>
                    <p>Ideal for 4-6 passengers. All-terrain capability with leather interiors.</p>
                </div>
            </div>
            <div class="vg-card">
                <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=500" alt="Travel Van">
                <div class="vg-info">
                    <span class="badge">Group</span>
                    <h3>Executive Minivan</h3>
                    <p>Perfect for families (up to 12 people). Fully air-conditioned with luggage space.</p>
                </div>
            </div>
        </div>

        <div id="guides-section" class="content-grid hidden">
            <div class="vg-card">
                <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=500" alt="Guide 1">
                <div class="vg-info">
                    <span class="badge">5+ Years Exp</span>
                    <h3>John Doe</h3>
                    <p>Expert in History and Architecture. Speaks English, Spanish, and French.</p>
                </div>
            </div>
            <div class="vg-card">
                <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=500" alt="Guide 2">
                <div class="vg-info">
                    <span class="badge">Nature Expert</span>
                    <h3>Sarah Smith</h3>
                    <p>Specializes in trekking and wildlife photography. Lead guide for Swiss Alps.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(type) {
            const vSec = document.getElementById('vehicles-section');
            const gSec = document.getElementById('guides-section');
            const btns = document.querySelectorAll('.tab-btn');

            btns.forEach(b => b.classList.remove('active'));
            
            if(type === 'vehicles') {
                vSec.classList.remove('hidden');
                gSec.classList.add('hidden');
                event.target.classList.add('active');
            } else {
                vSec.classList.add('hidden');
                gSec.classList.remove('hidden');
                event.target.classList.add('active');
            }
        }
    </script>
</body>
</html>