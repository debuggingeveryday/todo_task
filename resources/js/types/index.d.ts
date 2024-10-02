export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
    user_type: 'ADMIN_USER' | 'STAFF_USER';
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    auth: {
        user: User;
    };
};
