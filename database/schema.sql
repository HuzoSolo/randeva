-- Database schema for WhatsApp Appointment Booking System

-- Enable UUID extension
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

-- Users table (for both admins and businesses)
CREATE TABLE users (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(), -- UUID ile primary key oluşturuyoruz
    email VARCHAR(255) UNIQUE NOT NULL, -- email unique olacak
    password_hash VARCHAR(255) NOT NULL, -- şifre hash olacak
    first_name VARCHAR(100), -- ad
    last_name VARCHAR(100), -- soyad
    phone_number VARCHAR(20), -- telefon numarası
    role VARCHAR(20) NOT NULL CHECK (role IN ('admin', 'business')), -- admin veya business
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP, -- oluşturulma tarihi
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP, -- güncellenme tarihi
    is_active BOOLEAN DEFAULT true -- aktiflik durumu
);

-- Businesses table (extends users)
CREATE TABLE businesses (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(), -- UUID ile primary key oluşturuyoruz
    user_id UUID NOT NULL REFERENCES users(id), -- user_id ile users tablosunu referans alıyoruz
    business_name VARCHAR(255) NOT NULL, -- işletme adı
    business_type VARCHAR(100), -- işletme tipi
    address TEXT, -- adres
    timezone VARCHAR(50) DEFAULT 'UTC', -- zaman dilimi 
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP, -- oluşturulma tarihi
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP, -- güncellenme tarihi
    UNIQUE(user_id) -- user_id unique olacak
);

-- Subscriptions table
CREATE TABLE subscriptions (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(), -- UUID ile primary key oluşturuyoruz
    business_id UUID NOT NULL REFERENCES businesses(id), -- business_id ile businesses tablosunu referans alıyoruz
    plan_type VARCHAR(50) NOT NULL, -- plan tipi
    status VARCHAR(20) NOT NULL CHECK (status IN ('active', 'inactive', 'suspended')), -- durum
    start_date TIMESTAMP WITH TIME ZONE NOT NULL, -- başlangıç tarihi
    end_date TIMESTAMP WITH TIME ZONE, -- bitiş tarihi
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP, -- oluşturulma tarihi
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP -- güncellenme tarihi
);

-- WhatsApp menus table
CREATE TABLE whatsapp_menus (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(), -- UUID ile primary key oluşturuyoruz
    business_id UUID NOT NULL REFERENCES businesses(id), -- business_id ile businesses tablosunu referans alıyoruz
    menu_name VARCHAR(100) NOT NULL, -- menü adı
    menu_structure JSONB NOT NULL, -- menü yapısı
    is_active BOOLEAN DEFAULT true, -- aktiflik durumu
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP, -- oluşturulma tarihi
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP -- güncellenme tarihi
);

-- Customers table
CREATE TABLE customers (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(), -- UUID ile primary key oluşturuyoruz
    business_id UUID NOT NULL REFERENCES businesses(id), -- business_id ile businesses tablosunu referans alıyoruz
    whatsapp_number VARCHAR(20) NOT NULL, -- whatsapp numarası
    first_name VARCHAR(100), -- ad
    last_name VARCHAR(100), -- soyad
    email VARCHAR(255), -- email
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP, -- oluşturulma tarihi
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(business_id, whatsapp_number) -- business_id ve whatsapp_number unique olacak
);

-- Appointments table
CREATE TABLE appointments (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(), -- UUID ile primary key oluşturuyoruz
    business_id UUID NOT NULL REFERENCES businesses(id), -- business_id ile businesses tablosunu referans alıyoruz
    customer_id UUID NOT NULL REFERENCES customers(id), -- customer_id ile customers tablosunu referans alıyoruz
    appointment_date TIMESTAMP WITH TIME ZONE NOT NULL, -- randevu tarihi
    duration_minutes INTEGER NOT NULL, -- süre
    status VARCHAR(20) NOT NULL CHECK (status IN ('scheduled', 'completed', 'cancelled', 'no-show')), -- durum
    notes TEXT, -- notlar
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP, -- oluşturulma tarihi
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP -- güncellenme tarihi
);

-- Customer interactions table
CREATE TABLE customer_interactions (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(), -- UUID ile primary key oluşturuyoruz               
    business_id UUID NOT NULL REFERENCES businesses(id), -- business_id ile businesses tablosunu referans alıyoruz
    customer_id UUID NOT NULL REFERENCES customers(id), -- customer_id ile customers tablosunu referans alıyoruz
    interaction_type VARCHAR(50) NOT NULL, -- etkileşim tipi
    message_content TEXT, -- mesaj içeriği
    direction VARCHAR(10) CHECK (direction IN ('incoming', 'outgoing')), -- yön
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP -- oluşturulma tarihi
);

-- Business settings table
CREATE TABLE business_settings (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(), -- UUID ile primary key oluşturuyoruz
    business_id UUID NOT NULL REFERENCES businesses(id), -- business_id ile businesses tablosunu referans alıyoruz
    setting_key VARCHAR(100) NOT NULL, -- ayar anahtarı
    setting_value JSONB NOT NULL, -- ayar değeri
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP, -- oluşturulma tarihi
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP, -- güncellenme tarihi
    UNIQUE(business_id, setting_key) -- business_id ve setting_key unique olacak
);

-- Create indexes for better performance
CREATE INDEX idx_appointments_business_id ON appointments(business_id); -- business_id ile appointments tablosunu indexle
CREATE INDEX idx_appointments_customer_id ON appointments(customer_id); -- customer_id ile appointments tablosunu indexle
CREATE INDEX idx_appointments_date ON appointments(appointment_date); -- appointment_date ile appointments tablosunu indexle
CREATE INDEX idx_customer_interactions_business_id ON customer_interactions(business_id); -- business_id ile customer_interactions tablosunu indexle
CREATE INDEX idx_customer_interactions_customer_id ON customer_interactions(customer_id); -- customer_id ile customer_interactions tablosunu indexle
CREATE INDEX idx_customers_business_id ON customers(business_id); -- business_id ile customers tablosunu indexle
CREATE INDEX idx_whatsapp_menus_business_id ON whatsapp_menus(business_id); -- business_id ile whatsapp_menus tablosunu indexle 