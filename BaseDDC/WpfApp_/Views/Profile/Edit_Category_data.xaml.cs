using BaseDTO;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Forms;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Shapes;

namespace WpfApp_.Views.Profile
{
    /// <summary>
    /// Логика взаимодействия для Edit_Category_data.xaml
    /// </summary>
    public partial class Edit_Category_data : Window
    {
        private List<DTO_Category> _allCategory;
        private List<DTO_Category> _selectedCategory;
        private List<DTO_Category> _categoryCopy;
        private int _profileId;

        public Edit_Category_data(List<DTO_Category> current_categories, int profile_id)
        {
            _categoryCopy = new List<DTO_Category>();
            this._profileId = profile_id;
            foreach (var item in current_categories)
            {
                var category = new DTO_Category()
                {
                    id = item.id,
                    title = item.title
                };
                _categoryCopy.Add(category);
            }
            if (RestAPI.User.Role.title != "admin") RemoveSelect.IsEnabled = false;

            InitializeComponent();
            all_categories.SelectedValuePath = "id";
            all_categories.DisplayMemberPath = "title";
            selected_categories.SelectedValuePath = "id";
            selected_categories.DisplayMemberPath = "title";

            if (current_categories != null)
            {
                _selectedCategory = current_categories;
            }
            _allCategory = StaticInfoCollections.InfoCollections.categories.Except(current_categories).ToList<DTO_Category>();
            all_categories.ItemsSource = _allCategory;
            _selectedCategory = current_categories;
            selected_categories.ItemsSource = _selectedCategory;
        }

        private void Add_category_Click(object sender, RoutedEventArgs e)
        {
            if (all_categories.SelectedItem != null)
            {
                _selectedCategory.Add((DTO_Category)all_categories.SelectedItem);
                selected_categories.ItemsSource = _selectedCategory;
                selected_categories.Items.Refresh();
                if (_selectedCategory == null) return;
                _allCategory.Remove((DTO_Category)all_categories.SelectedItem);
                all_categories.ItemsSource = _allCategory;
                all_categories.Items.Refresh();
            }
        }

        private void Remove_category_Click(object sender, RoutedEventArgs e)
        {
            if (selected_categories.SelectedItem != null)
            {
                _allCategory.Add((DTO_Category)selected_categories.SelectedItem);
                all_categories.ItemsSource = _allCategory;
                all_categories.Items.Refresh();
                _selectedCategory.Remove((DTO_Category)selected_categories.SelectedItem);
                selected_categories.ItemsSource = _selectedCategory;
                selected_categories.Items.Refresh();
            }
        }

        private void Save_Click(object sender, RoutedEventArgs e)
        {
            try
            {
                var Update = new Update();
                Update.to_add = new List<int>();
                Update.to_delete = new List<int>();

                foreach (DTO_Category a in _selectedCategory)
                {
                    if (_categoryCopy.Where(x => x.id == a.id).Count() == 0) Update.to_add.Add(a.id);
                }

                foreach (DTO_Category a in _categoryCopy)
                {
                    if (_allCategory.Where(x => x.id == a.id).Count() > 0) Update.to_delete.Add(a.id);
                }

                DialogResult dialogResult = System.Windows.Forms.MessageBox.Show("Сохранение", "Сохранить изменения?", MessageBoxButtons.YesNo);
                if (dialogResult == System.Windows.Forms.DialogResult.Yes)
                {
                    Update.id = _profileId;
                    var result = RestAPI.PostRest("/Profile/UpdateCategory", Update);
                    this.Close();
                }
            }
            catch (Exception ex)
            {
                System.Windows.MessageBox.Show("Ошибка:" + ex.Message + "\n В методе:" + ex.TargetSite);
            }
        }

        private void Cancel_Click(object sender, RoutedEventArgs e)
        {
            this.Close();
        }
    }
}
