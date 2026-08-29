-- Seed Data for UnityDesignX Interior Design Platform
-- Database: unity

USE `unity`;

-- 1. Seed Roles
INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'admin'),
(2, 'customer')
ON DUPLICATE KEY UPDATE `role_name` = VALUES(`role_name`);

-- 2. Seed Users (Hashed Passwords using bcrypt)
INSERT INTO `users` (`user_id`, `role_id`, `full_name`, `email`, `password_hash`, `phone`, `address`) VALUES
(1, 1, 'System Admin', 'admin@unitydesign.com', '$2y$10$QtEUGUJ7szdbwkibJRXhie1HNVW4SBrIqFMccBp2Z11oDxyaKrTca', '+1 555-0192', '100 Admin Plaza, Suite 400'),
(2, 2, 'Tester', 'tester@gmail.com', '$2y$10$V4lQ/CR3HUv0gsv0OBpVkOpbGxTAuWSfiv5i5dnMCMyKU2GrvTCtu', '+91 9876543210', 'Chhatrapati Sambhajinagar, MH')
ON DUPLICATE KEY UPDATE `email` = VALUES(`email`);

-- 3. Seed Categories
INSERT INTO `categories` (`category_id`, `category_name`, `slug`, `description`, `image_url`) VALUES
(1, 'Beds & Bedroom', 'beds-bedroom', 'Luxury beds, ergonomic frames, and premium sleep aesthetics.', 'Categories/product category/FURNITURE/Beds/Images/bed1.jpg'),
(2, 'Cabinetry & Storage', 'cabinetry-storage', 'Modern bookcases, display units, and modular storage solutions.', 'Categories/product category/FURNITURE/Cabinetry/Images/cabin1.jpg'),
(3, 'Flooring & Tiles', 'flooring-tiles', 'Premium hardwood, marble finish tiles, and acoustic flooring.', 'Categories/product category/FURNITURE/Beds/Images/bed3.jpg'),
(4, 'Lighting & Chandeliers', 'lighting-chandeliers', 'Ambient architectural lights, pendant lamps, and smart LED fixtures.', 'Categories/product category/FURNITURE/Cabinetry/Images/cabin4.jpg'),
(5, 'Office Furniture', 'office-furniture', 'Executive desks, ergonomic chairs, and collaborative workstations.', 'Categories/product category/FURNITURE/Cabinetry/Images/cabin6.jpg')
ON DUPLICATE KEY UPDATE `category_name` = VALUES(`category_name`);

-- 4. Seed Products
INSERT INTO `products` (`product_id`, `category_id`, `title`, `slug`, `description`, `price`, `stock_quantity`, `main_image`, `is_featured`, `is_active`) VALUES
(1, 1, 'IKEA KALLAX Bed Frame', 'ikea-kallax-bed-frame', 'Minimalist wooden bed frame crafted with sustainable pine wood and clean geometric lines.', 1100.00, 15, 'Categories/product category/FURNITURE/Beds/Images/bed1.jpg', 1, 1),
(2, 1, 'BRIMNES Platform Bed', 'brimnes-platform-bed', 'Contemporary platform bed featuring integrated under-bed storage drawers and upholstered headboard.', 870.00, 10, 'Categories/product category/FURNITURE/Beds/Images/bed2.jpg', 1, 1),
(3, 1, 'Plush Homes Velvet Bed', 'plush-homes-velvet-bed', 'Ultra-luxurious queen bed with plush velvet upholstery and brushed gold metallic trim.', 1500.00, 8, 'Categories/product category/FURNITURE/Beds/Images/bed7.jpg', 0, 1),

(4, 2, 'BRIMNES Modern Bookcase', 'brimnes-modern-bookcase', 'Sleek multi-shelf storage unit designed for living spaces and home offices.', 800.00, 20, 'Categories/product category/FURNITURE/Cabinetry/Images/cabin3.jpg', 1, 1),
(5, 2, 'Nordic Oak Display Cabinet', 'nordic-oak-display-cabinet', 'Glass-fronted display cabinet with warm LED accents and solid oak craftsmanship.', 1250.00, 6, 'Categories/product category/FURNITURE/Cabinetry/Images/cabin6.jpg', 1, 1),

(6, 3, 'Acoustical Hardwood Flooring', 'acoustical-hardwood-flooring', 'Sound-dampening engineered hardwood planks with matte protective lacquer.', 650.00, 50, 'Categories/product category/FURNITURE/Beds/Images/bed3.jpg', 0, 1),

(7, 4, 'Linear LED Pendant Lamp', 'linear-led-pendant-lamp', 'Minimalist architectural ceiling light featuring dimmable warmth and brushed steel finish.', 420.00, 25, 'Categories/product category/FURNITURE/Cabinetry/Images/cabin4.jpg', 1, 1),

(8, 5, 'Executive Workstation Desk', 'executive-workstation-desk', 'Ergonomic dual-tone office desk with built-in cable management and privacy panel.', 1850.00, 12, 'Categories/product category/FURNITURE/Cabinetry/Images/cabin1.jpg', 1, 1)
ON DUPLICATE KEY UPDATE `title` = VALUES(`title`);

-- 5. Seed Cart Header & Cart Items
INSERT INTO `cart` (`cart_id`, `user_id`) VALUES
(1, 2)
ON DUPLICATE KEY UPDATE `user_id` = VALUES(`user_id`);

INSERT INTO `cart_items` (`cart_item_id`, `cart_id`, `product_id`, `quantity`) VALUES
(1, 1, 1, 1),
(2, 1, 5, 1)
ON DUPLICATE KEY UPDATE `quantity` = VALUES(`quantity`);

-- 6. Seed Contact Messages
INSERT INTO `contact_messages` (`message_id`, `full_name`, `email`, `subject`, `message`, `is_read`) VALUES
(1, 'User123', 'User@gmail.com', 'Interior Consultation', 'Hello! Interested in getting a full living room renovation quote.', 0),
(2, 'Demo User', 'demo@gmail.com', 'Office Space Design', 'Can you provide custom estimates for a 50-person office setup?', 1)
ON DUPLICATE KEY UPDATE `full_name` = VALUES(`full_name`);
