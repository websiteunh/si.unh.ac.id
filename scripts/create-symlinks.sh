#!/bin/bash
# Script to create symlinks for backward compatibility
# Run this on hosting if symlinks are supported

cd "$(dirname "$0")/../assets" || exit 1

# Remove existing symlinks if they exist
rm -f art1kel im493 dokum3nt

# Create symlinks
ln -s uploads/artikel art1kel
ln -s uploads/images im493
ln -s uploads/dokumen dokum3nt

echo "Symlinks created successfully!"
echo "art1kel -> uploads/artikel"
echo "im493 -> uploads/images"
echo "dokum3nt -> uploads/dokumen"

