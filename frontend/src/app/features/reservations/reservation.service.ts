import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Reservation } from './reservation.model';

@Injectable({
  providedIn: 'root'
})
export class ReservationService {
  private apiUrl = 'http://localhost:80/api/reservations';
  private token: string;
  private headers: HttpHeaders;
  private isAdmin = false;

    constructor(private http: HttpClient) {
      this.token = localStorage.getItem('jwt_token')!;
      this.headers = new HttpHeaders().set('Authorization', `Bearer ${this.token}`);
      this.isAdmin = localStorage.getItem('user_role') === 'admin';
    }

  getReservations(): Observable<any> {
    return this.http.get<any>(this.apiUrl, { headers: this.headers });
  }

  getReservation(id: number): Observable<Reservation> {
    return this.http.get<Reservation>(`${this.apiUrl}/${id}`, { headers: this.headers });
  }

  createReservation(reservation: Reservation): Observable<Reservation> {
    return this.http.post<Reservation>(this.apiUrl, reservation, { headers: this.headers });
  }

  updateReservation(id: number, reservation: Reservation): Observable<Reservation> {
    return this.http.put<Reservation>(`${this.apiUrl}/${id}`, reservation, { headers: this.headers });
  }

  deleteReservation(id: number): Observable<void> {
    return this.http.delete<void>(`${this.apiUrl}/${id}`, { headers: this.headers });
  }

  getOccupiedDates(startDate: string, endDate: string): Observable<string[]> {
    return this.http.get<any>(`${this.apiUrl}/occupied-dates?start=${startDate}&end=${endDate}`, { headers: this.headers });
  }
}
