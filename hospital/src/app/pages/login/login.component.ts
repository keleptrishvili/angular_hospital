import { Component } from '@angular/core';
import { FormBuilder, FormGroup, Validators, ReactiveFormsModule } from '@angular/forms';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [ReactiveFormsModule], // Remove HttpClientModule from here
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css'],
})
export class LoginComponent {
  form: FormGroup;
  errorMessage: string = '';

  constructor(
    private fb: FormBuilder,
    private http: HttpClient,
    private router: Router
  ) {
    this.form = this.fb.group({
      email: ['', [Validators.required, Validators.email]],
      password: ['', [Validators.required]],
    });
  }

  onSubmit() {
    if (this.form.valid) {
      const apiUrl = 'http://127.0.0.1:8000/api/login'; // Replace with your Laravel API URL
      this.http.post(apiUrl, this.form.value).subscribe(
        (response: any) => {
          if (response.token) {
            localStorage.setItem('token', response.token); // Save JWT Token
            this.router.navigate(['/dashboard']); // Redirect to dashboard after successful login
          }
        },
        (error) => {
          this.errorMessage = error.error.message || 'Invalid credentials. Please register first.';
        }
      );
    } else {
      this.errorMessage = 'Please fill out the form correctly.';
    }
  }
}
