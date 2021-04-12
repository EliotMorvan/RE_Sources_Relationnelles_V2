self.addEventListener('install', e => {
  e.waitUntil(
    caches.open('pwa').then(cache => {
      return cache.addAll([
		'/manifest.webmanifest',
        '/',
        '/sw.js',
        '/index.php',
        '/css/accueil.css',
        '/css/admin.css',
        '/css/profil.css',
        '/css/ressourceNav.css',
        '/css/signin.css',
        '/js/admin.js',
        '/logo/logo2.png',
      ])
      .then(() => self.skipWaiting());
    })
  )
});

self.addEventListener('activate',  event => {
  event.waitUntil(self.clients.claim());
});

self.addEventListener('fetch', event => {
  event.respondWith(
    caches.match(event.request).then(response => {
      return response || fetch(event.request);
    })
  );
});