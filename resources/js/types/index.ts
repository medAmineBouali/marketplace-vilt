export type Role = 'admin' | 'seller' | 'customer';

export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
    role: Role;
    shop?: Shop; // Relation optionnelle
}

export interface Shop {
    id: number;
    user_id: number;
    name: string;
    slug: string;
    description: string | null;
    logo: string | null;
    is_active: boolean;
    seller?: User;
    products?: Product[];
    created_at: string;
}

export interface Category {
    id: number;
    name: string;
    slug: string;
    parent_id: number | null;
    children?: Category[];
}

export interface Product {
    id: number;
    shop_id: number;
    category_id: number;
    name: string;
    slug: string;
    description: string;
    price: number;
    stock_quantity: number;
    image: string | null;
    shop?: Shop;
    category?: Category;
    reviews?: Review[];
    average_rating?: number; // Via l'attribut calculé dans Eloquent
}

export interface Review {
    id: number;
    user_id: number;
    product_id: number;
    rating: number;
    comment: string | null;
    user?: User;
    created_at: string;
}

export interface Order {
    id: number;
    user_id: number;
    total_price: number;
    status: 'pending' | 'processing' | 'completed' | 'cancelled';
    payment_status: 'unpaid' | 'paid';
    transaction_id: string | null;
    items?: OrderItem[];
    created_at: string;
}

export interface OrderItem {
    id: number;
    order_id: number;
    product_id: number;
    quantity: number;
    price: number;
    product?: Product;
}

// Global Inertia Props
export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
    flash: {
        message: string | null;
        error: string | null;
    };
};
