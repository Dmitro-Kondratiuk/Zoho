export const Stages = [
    'Qualification',
    'Needs Analysis',
    'Value Proposition',
    'Identify Decision Makers',
    'Proposal/Price Quote',
    'Closed Lost to Competition',
    'Closed Lost',
    'Closed Won',
    'Negotiation/Review'
] as const;

export interface Deal  {
    id?: number
    Deal_Name: string,
    Stage: typeof Stages[number],
}
