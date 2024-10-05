import { Routes } from '@angular/router';
import { EventSpaceListComponent } from './features/event-space/event-space-list/event-space-list.component';
import { EventSpaceDetailsComponent } from './features/event-space/event-space-detail/event-space-detail.component';
import { ReservationFormComponent } from './features/reservations/reservation-form/reservation-form.component';
import { ReservationListComponent } from './features/reservations/reservation-list/reservation-list.component';
import { AuthGuard } from './features/auth/guards/auth.guard';
import { AdminGuard } from './features/auth/guards/admin.guard';
import { LoginComponent } from './features/auth/login/login.component';
import { LogoutComponent } from './features/auth/logout/logout.component';

export const routes: Routes = [
  { path: 'event-spaces', component: EventSpaceListComponent },
  { path: 'login', component: LoginComponent },
  { path: 'event-spaces/:id', component: EventSpaceDetailsComponent },
  { path: 'reservations', component: ReservationListComponent, canActivate: [AuthGuard] },
  /*{
    path: 'admin',
    loadComponent: () => import('').then(m => m.AdminComponent),
    canActivate: [AuthGuard, AdminGuard] // Protegido por ambos guards
  },**/
  { path: 'logout', component: LogoutComponent },

];
