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
    m_saving: SavingProperties | null;
    address: string | null;
    contact: string | null;
}

interface SavingProperties {
    id: number | null;
    user: UserProperties | null;
    deposit_amount: number | null;
    loan_amount: number | null;
}

interface SupplierProperties {
    id: string | number | null;
    name: string | null;
    address: string | null;
    contact: string | null;
}

interface ItemCategoryProperties {
    id: string | number | null;
    category: string | null;
}
interface ItemProperties {
    id: string | number | null;
    supplier: SupplierProperties | null;
    item_category: ItemCategoryProperties | null;
    name: string | null;
    stock: number | null;
    price: number | null;
}

export {
    UserProperties,
    DivisionProperties,
    SupplierProperties,
    ItemProperties,
    ItemCategoryProperties,
    SavingProperties,
};
