export interface Reservation {
    event_space_id: number;
    event_name: string;
    start_time: string;
    end_time: string;
    status: string;
    duration?: number;
  }
  