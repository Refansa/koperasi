interface CommonProperties {
    id: number;
    created_at: string;
    updated_at: string;
}

interface DivisionProperties extends CommonProperties {
    position: string | null;
}

interface CooperativeProperties extends CommonProperties {
    total_deposit_amount: number;
    total_loan_amount: number;
}

interface SettingProperties extends CommonProperties {
    minimum_basic_cost: number;
    minimum_mandatory_cost: number;
    maximum_loan_amount: number;
    saving_limit_for_loan: number;
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
    basic_amount: number | null;
    mandatory_amount: number | null;
    voluntary_amount: number | null;
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

type DepositType = 'Pokok' | 'Wajib' | 'Sukarela' | 'Donasi';

interface DepositProperties extends CommonProperties {
    user: UserProperties | null;
    transaction: TransactionProperties | null;
    type: DepositType | null;
}

type WithdrawType = 'Pokok' | 'Wajib' | 'Sukarela' | 'Semua';

interface WithdrawProperties extends CommonProperties {
    user: UserProperties | null;
    transaction: TransactionProperties | null;
    type: WithdrawType | null;
}

interface LoanProperties extends CommonProperties {
    user: UserProperties | null;
    transaction: TransactionProperties | null;
    loan_period: number;
    interest: number;
    note: string | null;
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
    DepositType,
    WithdrawProperties,
    WithdrawType,
    LoanProperties,
    SettingProperties,
    CooperativeProperties,
};
