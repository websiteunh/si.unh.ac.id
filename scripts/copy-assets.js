#!/usr/bin/env node

/**
 * Copy frontend assets from node_modules to assets/vendor
 * This script runs after npm install to organize frontend libraries
 */

const fs = require('fs');
const path = require('path');

const assetsDir = path.join(__dirname, '..', 'assets', 'vendor');
const nodeModulesDir = path.join(__dirname, '..', 'node_modules');

// Ensure assets/vendor directory exists
if (!fs.existsSync(assetsDir)) {
  fs.mkdirSync(assetsDir, { recursive: true });
}

// Mapping of npm packages to destination folders
const assetMap = {
  'bootstrap': {
    src: 'dist',
    dest: 'bootstrap'
  },
  'jquery': {
    src: 'dist',
    dest: 'jquery'
  },
  'datatables.net-bs4': {
    src: '.',
    dest: 'datatables-bs4'
  },
  'select2': {
    src: 'dist',
    dest: 'select2'
  },
  'sweetalert2': {
    src: 'dist',
    dest: 'sweetalert2'
  },
  'chart.js': {
    src: 'dist',
    dest: 'chart.js'
  },
  'summernote': {
    src: 'dist',
    dest: 'summernote'
  },
  'moment': {
    src: '.',
    dest: 'moment'
  },
  'fullcalendar': {
    src: '.',
    dest: 'fullcalendar'
  },
  'aos': {
    src: 'dist',
    dest: 'aos'
  },
  'glightbox': {
    src: 'dist',
    dest: 'glightbox'
  },
  'swiper': {
    src: '.',
    dest: 'swiper'
  },
  'bootstrap-icons': {
    src: 'font',
    dest: 'bootstrap-icons'
  }
};

function copyRecursive(src, dest) {
  if (!fs.existsSync(src)) {
    console.warn(`Source not found: ${src}`);
    return false;
  }

  const stat = fs.statSync(src);
  
  if (stat.isDirectory()) {
    if (!fs.existsSync(dest)) {
      fs.mkdirSync(dest, { recursive: true });
    }
    
    const files = fs.readdirSync(src);
    files.forEach(file => {
      const srcPath = path.join(src, file);
      const destPath = path.join(dest, file);
      copyRecursive(srcPath, destPath);
    });
  } else {
    fs.copyFileSync(src, dest);
  }
  
  return true;
}

console.log('Copying frontend assets from node_modules to assets/vendor...\n');

let copied = 0;
let skipped = 0;

Object.entries(assetMap).forEach(([pkg, config]) => {
  const srcPath = path.join(nodeModulesDir, pkg, config.src);
  const destPath = path.join(assetsDir, config.dest);
  
  if (copyRecursive(srcPath, destPath)) {
    console.log(`✓ Copied ${pkg} → assets/vendor/${config.dest}`);
    copied++;
  } else {
    console.log(`✗ Skipped ${pkg} (not found in node_modules)`);
    skipped++;
  }
});

console.log(`\nDone! Copied ${copied} packages, skipped ${skipped} packages.`);

