interface CommonProperties {
    id: number;
    created_at: string;
    updated_at: string;
}

interface DivisionProperties extends CommonProperties {
    position: string | null;
}

interface UserProperties extends CommonProperties {
    name: string | null;
    email: string | null;
    role: string | null;
    division: DivisionProperties | null;
    m_saving: SavingProperties | null;
    address: string | null;
    contact: string | null;
}

interface SavingProperties extends CommonProperties {
    user: UserProperties | null;
    deposit_amount: number | null;
    loan_amount: number | null;
}

interface SupplierProperties extends CommonProperties {
    name: string | null;
    address: string | null;
    contact: string | null;
}

interface ItemCategoryProperties extends CommonProperties {
    category: string | null;
}
interface ItemProperties extends CommonProperties {
    supplier: SupplierProperties | null;
    item_category: ItemCategoryProperties | null;
    name: string | null;
    stock: number | null;
    price: number | null;
}

interface DepositProperties extends CommonProperties {
    user: UserProperties | null;
    transaction: TransactionProperties | null;
}

interface WithdrawProperties extends CommonProperties {
    user: UserProperties | null;
    transaction: TransactionProperties | null;
}

interface TransactionProperties extends CommonProperties {
    user: UserProperties | null;
    amount: number | null;
    deposit?: DepositProperties | null;
    withdraw?: WithdrawProperties | null;
}

export {
    UserProperties,
    DivisionProperties,
    SupplierProperties,
    ItemProperties,
    ItemCategoryProperties,
    SavingProperties,
    TransactionProperties,
    DepositProperties,
    WithdrawProperties,
};
