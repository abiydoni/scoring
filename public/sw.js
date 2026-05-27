// sw.js – Simple Service Worker for Scoring App PWA
const CACHE_NAME = 'scoring-pwa-v2';
const PRECACHE_URLS = [
  '/',
  '/manifest.json',
  '/score.png',
];

self.addEventListener('install', (event) => {
  // Pre‑cache defined resources
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => cache.addAll(PRECACHE_URLS))
  );
});

self.addEventListener('activate', (event) => {
  // Clean up old caches
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames.map((cache) => {
          if (cache !== CACHE_NAME) {
            return caches.delete(cache);
          }
        })
      );
    })
  );
});

self.addEventListener('fetch', (event) => {
  // Use Network-First for ALL requests to ensure we always get the latest PHP/HTML/JS
  event.respondWith(
    fetch(event.request).then((networkResponse) => {
      // Update cache with the new response
      const responseClone = networkResponse.clone();
      caches.open(CACHE_NAME).then((cache) => {
        // Do not cache API or POST requests
        if (event.request.method === 'GET') {
          cache.put(event.request, responseClone);
        }
      });
      return networkResponse;
    }).catch(() => {
      // Fallback to cache if offline
      return caches.match(event.request);
    })
  );
});
