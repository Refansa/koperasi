interface DivisionProperties {
    id: number | null;
    position: string | null;
}

interface UserProperties {
    id: string | number | null;
    name: string | null;
    email: string | null;
    role: string | null;
    division: DivisionProperties | null;
    address: string | null;
    contact: string | null;
}

interface SupplierProperties {
    id: string | number | null;
    name: string | null;
    address: string | null;
    contact: string | null;
}

interface ItemProperties {
    id: string | number | null;
    supplier: SupplierProperties | null;
    name: string | null;
    stock: number | null;
    price: number | null;
}

export { UserProperties, DivisionProperties, SupplierProperties, ItemProperties };
