<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Space Themed Game Menu</title>
<style>
.fullscreen-menu {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh; /* Fullscreen height */
  width: 100vw; /* Fullscreen width */
  position: relative;
  overflow: hidden;
  background-color: #F9F871; /* Keep the vibrant background */
}

.menu {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 20px;
  z-index: 2; /* Ensure menu is above the animated background */
}

.menu-item {
  text-decoration: none;
  color: #5D3FD3;
  font-size: 24px;
  font-weight: bold;
  margin: 15px;
  padding: 15px 25px;
  border-radius: 20px;
  background-color: #A1EAFB;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.menu-item:hover, .menu-item:focus {
  transform: scale(1.05);
  animation: none; /* Override any previous animation for simplicity */
}

/* Animated Background */
@keyframes backgroundAnimation {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

.fullscreen-menu {
  background: linear-gradient(132deg, #F9F871, #A1EAFB, #F9F871, #A1EAFB);
  background-size: 400% 400%;
  animation: backgroundAnimation 10s ease infinite;
}

/* Optional: Add a subtle 'floating' animation to the menu itself */
@keyframes float {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-20px); }
}

.menu {
  animation: float 6s ease-in-out infinite;
}

</style>
</head>
<body>
<div class="fullscreen-menu">
  <div class="menu">
    <a href="#" class="menu-item">Play</a>
    <a href="#" class="menu-item">Badges</a>
    <a href="#" class="menu-item">Stats</a>
    <a href="#" class="menu-item">Logout</a>
  </div>
</div>
</body>
</html>
