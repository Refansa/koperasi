interface CommonProperties {
    id: number;
    created_at: string;
    updated_at: string;
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
    picture: string | null;
    gender: 'Laki-laki' | 'Perempuan' | null;
    age: number | null;
    occupation: string | null;
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

type LoanStatusType = 'PAID' | 'UNPAID';

interface LoanProperties extends CommonProperties {
    user: UserProperties | null;
    transaction: TransactionProperties | null;
    installment_tracker: InstallmentTrackerProperties;
    loan_period: number;
    interest: number;
    note: string | null;
    status: LoanStatusType;
}

interface InstallmentProperties extends CommonProperties {
    user: UserProperties | null;
    transaction: TransactionProperties | null;
    loan: LoanProperties | null;
    installment_tracker: InstallmentTrackerProperties;
    installment_of: number;
    installment_left: number;
    note: string | null;
}

interface InstallmentTrackerProperties extends CommonProperties {
    user: UserProperties | null;
    loan: LoanProperties | null;
    installment_of: number;
    installment_needed: number;
}

interface TransactionProperties extends CommonProperties {
    user: UserProperties | null;
    amount: number | null;
    deposit?: DepositProperties | null;
    withdraw?: WithdrawProperties | null;
    loan?: LoanProperties | null;
    installment?: InstallmentProperties | null;
}

export {
    UserProperties,
    SavingProperties,
    TransactionProperties,
    DepositProperties,
    DepositType,
    WithdrawProperties,
    WithdrawType,
    LoanProperties,
    LoanStatusType,
    SettingProperties,
    CooperativeProperties,
    InstallmentProperties,
    InstallmentTrackerProperties,
};
