using System;
using System.Collections.Generic;

namespace BaseDDC.model
{
    public partial class User
    {
        public int Id { get; set; }
        public string Login { get; set; }
        public string Pass { get; set; }
        public string Salt { get; set; }
        public string Token { get; set; }
        public string SName { get; set; }
        public string FName { get; set; }
        public string Patr { get; set; }
        public int? RoleId { get; set; }

        public UserRole Role { get; set; }
    }
}
