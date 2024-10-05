import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ConfirmDialogComponentComponent } from './confirm-dialog.component.component';

describe('ConfirmDialogComponentComponent', () => {
  let component: ConfirmDialogComponentComponent;
  let fixture: ComponentFixture<ConfirmDialogComponentComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ConfirmDialogComponentComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ConfirmDialogComponentComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
