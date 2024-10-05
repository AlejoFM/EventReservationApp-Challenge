import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class EventSpaceService {
  private apiUrl = 'http://localhost:80/api/event_spaces'; 
  private token: string;
  private headers: HttpHeaders;
  private isAdmin = false;

    constructor(private http: HttpClient) {
      this.token = localStorage.getItem('jwt_token')!;
      this.headers = new HttpHeaders().set('Authorization', `Bearer ${this.token}`);
      this.isAdmin = localStorage.getItem('user_role') === 'admin';
    }
    
    getEventSpaces(pageIndex: number, pageSize: number, filters: {pagination?: boolean, type?: string; capacity?: number; startDate?: string; endDate?: string } = {}): Observable<any> {
      let params = new HttpParams()
        .set('page', pageIndex.toString())
        .set('size', pageSize.toString());
    
      if (filters.type) params = params.append('type', filters.type);
      if (filters.capacity) params = params.append('capacity', filters.capacity.toString());
      if (filters.startDate) params = params.append('start_time', filters.startDate);
      if (filters.endDate) params = params.append('end_time', filters.endDate);
      if (filters.pagination) params = params.append('pagination', filters.pagination.toString());
      
      return this.http.get<any>(`${this.apiUrl}`, { params, headers: this.headers }, );
    }
    // Agregar un nuevo espacio de evento
    addEventSpace(eventSpace: any): Observable<any> {
      return this.http.post<any>(this.apiUrl, eventSpace, { headers: this.headers });
    }
  
    // Editar un espacio de evento existente
    updateEventSpace(eventSpaceId: string, eventSpace: any): Observable<any> {
      return this.http.put<any>(`${this.apiUrl}/${eventSpaceId}`, eventSpace, { headers: this.headers });
    }
  
    // Eliminar un espacio de evento
    deleteEventSpace(eventSpaceId: string): Observable<any> {
      return this.http.delete<any>(`${this.apiUrl}/${eventSpaceId}`, { headers: this.headers });
    }
  
    // Obtener un espacio de evento por ID
    getEventSpaceById(eventSpaceId: number): Observable<any> {
      return this.http.get<any>(`${this.apiUrl}/${eventSpaceId}`);
    }
}